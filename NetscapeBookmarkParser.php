<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Katzgrau\KLogger\Logger;

/**
 * Generic Netscape bookmark parser
 */
class NetscapeBookmarkParser implements LoggerAwareInterface
{
    protected $keepNestedTags;
    protected $defaultTags;
    protected $defaultPub;
    protected $normalizeDates;
    protected $dateRange;

    /**
     * @var LoggerInterface instance.
     */
    protected $logger;

    protected const TRUE_PATTERN = 'y|yes|on|checked|ok|1|true|array|\+|okay|yes|t|one';
    protected const FALSE_PATTERN = 'n|no|off|empty|null|false|nil|0|-|exit|die|neg|f|zero|void';

    /**
     * Instantiates a new NetscapeBookmarkParser
     *
     * @param bool        $keepNestedTags Tag links with parent folder names
     * @param array|null  $defaultTags    Tag all links with these values
     * @param mixed       $defaultPub     Link publication status if missing
     *                                      - '1' => public
     *                                      - '0' => private)
     * @param string|null $logDir         Log directory
     * @param bool        $normalizeDates Whether parsed dates are expected to fall within
     *                                    a given date/time interval
     * @param string      $dateRange      Delta used to compute the "acceptable" date/time interval
     */
    public function __construct(
        bool $keepNestedTags = true,
        ?array $defaultTags = [],
        $defaultPub = '0',
        string $logDir = null,
        bool $normalizeDates = true,
        string $dateRange = '30 years'
    ) {
        if ($keepNestedTags) {
            $this->keepNestedTags = true;
        }
        if ($defaultTags !== null) {
            $this->defaultTags = $defaultTags;
        } else {
            $this->defaultTags = [];
        }
        $this->defaultPub = $defaultPub;

        $this->setLogger(new Logger(
            $logDir == null ? 'logs/' : $logDir,
            LogLevel::INFO,
            [
                'prefix' => 'import.',
                'extension' => 'log',
            ]
        ));

        $this->normalizeDates = $normalizeDates;
        $this->dateRange = $dateRange;
    }

    /**
     * Parses a Netscape bookmark file
     *
     * @param string $filename Bookmark file to parse
     *
     * @return array An associative array containing parsed links
     */
    public function parseFile(string $filename): array
    {
        $this->logger->info('Starting to parse ' . $filename);
        return $this->parseString(file_get_contents($filename));
    }

    /**
     * Parses a string containing Netscape-formatted bookmarks
     *
     * Output format:
     *
     *     Array
     *     (
     *         [0] => Array
     *             (
     *                 [note]  => Some comments about this link
     *                 [pub]   => 1
     *                 [tags]  => ['a', 'list', 'of', 'tags']
     *                 [time]  => 1459371397
     *                 [title] => Some page
     *                 [uri]   => http://domain.tld:5678/some-page.html
     *             )
     *         [1] => Array
     *             (
     *                 ...
     *             )
     *     )
     *
     * @param string $bookmarkString String containing Netscape bookmarks
     *
     * @return array An associative array containing parsed links
     */
    public function parseString(string $bookmarkString): array
    {
        $folderTags = [];
        $groupedFolderTags = [];

        $items = [];

        $lines = explode("\n", $this->sanitizeString($bookmarkString));

        foreach ($lines as $lineNumber => $line) {
            $item = [];

            $this->logger->info('PARSING LINE #' . $lineNumber);
            $this->logger->debug('[#' . $lineNumber . '] Content: ' . $line);
            if (preg_match('/^<h\d.*>(.*)<\/h\d>/i', $line, $header)) {
                // a header is matched:
                // - links may be grouped in a (sub-)folder
                // - append the header's content to the folder tags
                $tag = static::sanitizeTags($header[1]);

                $groupedFolderTags[] = $tag;
                $folderTags = static::flattenTagsList($groupedFolderTags);
                $this->logger->debug('[#' . $lineNumber . '] Header found: ' . implode(' ', $tag));
                continue;
            } elseif (preg_match('/^<\/DL>/i', $line)) {
                // </DL> matched: stop using header value
                $tag = array_pop($groupedFolderTags);
                $folderTags = static::flattenTagsList($groupedFolderTags);
                $this->logger->debug('[#' . $lineNumber . '] Header ended: ' . implode(' ', $tag ?? []));
                continue;
            }

            if (preg_match('/<a/i', $line)) {
                $this->logger->debug('[#' . $lineNumber . '] Link found');
                if (preg_match('/href="(.*?)"/i', $line, $href)) {
                    $item['uri'] = $href[1];
                    $this->logger->debug('[#' . $lineNumber . '] URL found: ' . $href[1]);
                } else {
                    $item['uri'] = '';
                    $this->logger->debug('[#' . $lineNumber . '] Empty URL');
                }

                if (preg_match('/icon="(.*?)"/i', $line, $icon)) {
                    $item['icon'] = $icon[1];
                    $this->logger->debug('[#' . $lineNumber . '] ICON found: ' . $href[1]);
                } else {
                    $item['icon'] = '';
                    $this->logger->debug('[#' . $lineNumber . '] Empty ICON');
                }

                if (preg_match('/<a.*?[^br]>(.*?)<\/a>/i', $line, $title)) {
                    $item['title'] = $title[1];
                    $this->logger->debug('[#' . $lineNumber . '] Title found: ' . $title[1]);
                } else {
                    $item['title'] = 'untitled';
                    $this->logger->debug('[#' . $lineNumber . '] Empty title');
                }

                if (preg_match('/(description|note)="(.*?)"/i', $line, $description)) {
                    $item['note'] = $description[2];
                    $this->logger->debug(
                        '[#' . $lineNumber . '] Content found: ' . substr($description[2], 0, 50) . '...'
                    );
                } elseif (preg_match('/<dd>(.*?)$/i', $line, $note)) {
                    $item['note'] = str_replace('<br>', "\n", $note[1]);
                    $this->logger->debug('[#' . $lineNumber . '] Content found: ' . substr($note[1], 0, 50) . '...');
                } else {
                    $item['note'] = '';
                    $this->logger->debug('[#' . $lineNumber . '] Empty content');
                }

                $tags = [];
                if ($this->defaultTags) {
                    $tags = array_merge($tags, $this->defaultTags);
                }
                if ($this->keepNestedTags) {
                    $tags = array_merge($tags, $folderTags);
                }

                if (preg_match('/(tags?|labels?|folders?)="(.*?)"/i', $line, $labels)) {
                    $separator = strpos($labels[2], ',') !== false ? ',' : ' ';
                    $tags = array_merge(
                        $tags,
                        static::splitTagString($labels[2], $separator)
                    );
                }
                $item['tags'] = $tags;
                $this->logger->debug('[#' . $lineNumber . '] Tag list: ' . implode(' ', $item['tags']));

                if (preg_match('/add_date="(.*?)"/i', $line, $addDate)) {
                    $item['time'] = $this->parseDate($addDate[1]);
                } else {
                    $item['time'] = time();
                }
                $this->logger->debug('[#' . $lineNumber . '] Date: ' . $item['time']);

                if (preg_match('/(public|published|pub)="(.*?)"/i', $line, $public)) {
                    $item['pub'] = $this->parseBoolean($public[2]) ? 1 : 0;
                } elseif (preg_match('/(private|shared)="(.*?)"/i', $line, $private)) {
                    $item['pub'] = $this->parseBoolean($private[2]) ? 0 : 1;
                } else {
                    $item['pub'] = $this->defaultPub;
                }
                $this->logger->debug(
                    '[#' . $lineNumber . '] Visibility: ' . ($item['pub'] ? 'public' : 'private')
                );

                $items[] = $item;
            }
        }

        $this->logger->info('File parsing ended');
        return $items;
    }

    /**
     * Parses a formatted date
     *
     * @see http://php.net/manual/en/datetime.formats.compound.php
     * @see http://php.net/manual/en/function.strtotime.php
     *
     * @param string $date formatted date
     *
     * @return int Unix timestamp corresponding to a successfully parsed date,
     *             else current date and time
     */
    public function parseDate(string $date): int
    {
        if (strtotime('@' . $date)) {
            // Unix timestamp
            if ($this->normalizeDates) {
                $date = $this->normalizeDate($date);
            }
            return strtotime('@' . $date);
        } elseif (strtotime($date)) {
            // attempt to parse a known compound date/time format
            return strtotime($date);
        }

        // current date & time
        return time();
    }

    /**
     * Normalizes a date by supposing it is comprised in a given range
     *
     * Although most bookmarking services return dates formatted as a Unix epoch
     * (seconds elapsed since 1970-01-01 00:00:00) or human-readable strings,
     * some services return microtime epochs (microseconds elapsed since
     * 1970-01-01 00:00:00.000000) WITHOUT using a delimiter for the microseconds
     * part...
     *
     * This is likely to raise issues in the distant future!
     *
     * @see https://stackoverflow.com/questions/33691428/datetime-with-microseconds
     * @see https://stackoverflow.com/questions/23929145/how-to-test-if-a-given-time-stamp-is-in-seconds-or-milliseconds
     * @see https://stackoverflow.com/questions/539900/google-bookmark-export-date-format
     * @see https://www.wired.com/2010/11/1110mars-climate-observer-report/
     *
     * @param string $epoch     Unix timestamp to normalize
     *
     * @return int Unix timestamp in seconds, within the expected range
     */
    public function normalizeDate(string $epoch): int
    {
        $date = new \DateTime('@' . $epoch);
        $maxDate = new \DateTime('+' . $this->dateRange);

        for ($i = 1; $date > $maxDate; $i++) {
            // trim the provided date until it falls within the expected range
            $date = new \DateTime('@' . substr($epoch, 0, strlen($epoch) - $i));
        }

        return $date->getTimestamp();
    }


    /**
     * Parses the value of a supposedly boolean attribute
     *
     * @param string $value   Attribute value to evaluate
     *
     * @return mixed 'true' when the value is evaluated as true
     *               'false' when the value is evaluated as false
     *               $this->defaultPub if the value is not a boolean
     */
    public function parseBoolean($value)
    {
        if (! $value) {
            return false;
        }
        if (! is_string($value)) {
            return true;
        }

        if (preg_match("/^(" . self::TRUE_PATTERN . ")$/i", $value)) {
            return true;
        }
        if (preg_match("/^(" . self::FALSE_PATTERN . ")$/i", $value)) {
            return false;
        }
        return $this->defaultPub;
    }

    /**
     * Sanitizes the content of a string containing Netscape bookmarks
     *
     * This removes:
     * - comment blocks
     * - metadata: DOCTYPE, H1, META, TITLE
     * - extra newlines, trailing spaces and tabs
     *
     * @param string $bookmarkString Original bookmark string
     *
     * @return string Sanitized bookmark string
     */
    public static function sanitizeString(string $bookmarkString): string
    {
        // trim comments
        $bookmarkString = preg_replace('@<!--.*?-->@mis', '', $bookmarkString);

        // keep one XML element per line to prepare for linear parsing
        $bookmarkString = preg_replace('@>(\s*?)<@mis', ">\n<", $bookmarkString);

        // trim unused metadata
        $bookmarkString = preg_replace('@(<!DOCTYPE|<META|<TITLE|<H1|<P).*\n@i', '', $bookmarkString);

        // trim whitespace
        $bookmarkString = trim($bookmarkString);

        // trim carriage returns
        $bookmarkString = str_replace("\r", '', $bookmarkString);

        // convert multiline descriptions to one-line descriptions
        // line feeds are converted to <br>
        $bookmarkString = preg_replace_callback(
            '@<DD>(.*?)(</?(:?DT|DD|DL))@mis',
            function ($match) {
                return '<DD>' . str_replace("\n", '<br>', trim($match[1])) . PHP_EOL . $match[2];
            },
            $bookmarkString
        );

        // convert multiline descriptions inside <A> tags to one-line descriptions
        // line feeds are converted to <br>
        $bookmarkString = preg_replace_callback(
            '@<A(.*?)</A>@mis',
            function ($match) {
                return '<A ' . str_replace("\n", '<br>', trim($match[1])) . '</A>';
            },
            $bookmarkString
        );

        // concatenate all information related to the same entry on the same line
        // e.g. <A HREF="...">My Link</A><DD>List<br>- item1<br>- item2
        $bookmarkString = preg_replace('@\n<br>@mis', "<br>", $bookmarkString);
        $bookmarkString = preg_replace('@\n<DD@i', '<DD', $bookmarkString);

        return $bookmarkString;
    }

    /**
     * Split tag string using provided separator.
     *
     * @param string $tagString Tag string
     * @param string $separator
     *
     * @return array List of tags (trimmed and filtered)
     */
    public static function splitTagString(string $tagString, string $separator): array
    {
        $tags = explode($separator, strtolower($tagString));

        // remove multiple consecutive whitespaces
        $tags = preg_replace('/\s{2,}/', ' ', $tags);

        return array_values(array_filter(array_map('trim', $tags)));
    }

    /**
     * Sanitizes a space-separated list of tags
     *
     * This removes:
     * - duplicate whitespace
     * - leading punctuation
     * - undesired characters
     *
     * @param string $tagString Space-separated list of tags
     *
     * @return array List of sanitized tags
     */
    public static function sanitizeTags(string $tagString): array
    {
        $separator = strpos($tagString, ',') !== false ? ',' : ' ';
        $tags = static::splitTagString($tagString, $separator);

        foreach ($tags as $key => &$value) {
            if (ctype_alnum($value)) {
                continue;
            }

            $keepWhiteSpaces = $separator !== ' ';

            $value = strtolower($value);

            // trim leading punctuation
            $value = preg_replace('/^[[:punct:]]/', '', $value);

            // trim all but alphanumeric characters, underscores and non-leading dashes
            $value = preg_replace('/[^\p{L}\p{N}\-_' . ($keepWhiteSpaces ? ' ' : '') . ']++/u', '', $value);

            if ($value == '') {
                unset($tags[$key]);
            }
        }

        return array_values($tags);
    }

    /**
     * Flatten a multi-dimensions array of tags into a one-dimension array.
     *
     * @param array $groupedTags Array of arrays of tags
     *
     * @return array Flatten tags list
     */
    public static function flattenTagsList(array $groupedTags): array
    {
        return array_reduce($groupedTags, function (array $carry, array $item) {
            return array_merge($carry, $item);
        }, []);
    }

    /**
     * Set the logger, must be PSR-3 compliant.
     *
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
