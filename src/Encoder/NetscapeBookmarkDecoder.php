<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Encoder;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Generic Netscape bookmark decoder.
 */
class NetscapeBookmarkDecoder
{
    public const FORMAT = 'netscape';

    /**
     * keep_nested_tags: boolean
     *     Tag links with parent folder names
     */
    public const KEEP_NESTED_TAGS = 'keep_nested_tags';

    /**
     * normalize_dates: boolean
     *     Whether parsed dates are expected to fall within a given date/time interval
     */
    public const NORMALIZE_DATES = 'normalize_dates';

    /**
     * date_range: string
     *     Delta used to compute the "acceptable" date/time interval
     */
    public const DATE_RANGE = 'date_range';

    public const DEFAULT_KEEP_NESTED_TAGS = true;
    public const DEFAULT_NORMALIZE_DATES = true;
    public const DEFAULT_DATE_RANGE = '30 years';

    public const TRUE_PATTERN = '1|\+|array|checked|ok|okay|on|one|t|true|y|yes';
    public const FALSE_PATTERN = '-|0|die|empty|exit|f|false|n|neg|nil|no|null|off|void|zero';

    private $defaultContext = [
        self::KEEP_NESTED_TAGS => self::DEFAULT_KEEP_NESTED_TAGS,
        self::NORMALIZE_DATES  => self::DEFAULT_NORMALIZE_DATES,
        self::DATE_RANGE       => self::DEFAULT_DATE_RANGE,
    ];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $defaultContext = [], LoggerInterface $logger = null)
    {
        $this->defaultContext = array_merge($this->defaultContext, $defaultContext);
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * Checks whether the deserializer can decode from given format.
     *
     * @param string $format Format name
     *
     * @return bool
     */
    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }

    /**
     * Decodes a string containing Netscape-formatted bookmarks into PHP data.
     *
     * Output format:
     *
     * array(2) {
     *     [0]=> array(7) {
     *         ['name'] => string(9) 'Some page'
     *         ['image'] => string(26) 'data:image/png;base64, ...'
     *         ['url'] => string(37) 'https://domain.tld:5678/some-page.html'
     *         ['tags'] => array(4) {
     *             [0] => string(1) 'a'
     *             [1] => string(4) 'list'
     *             [2] => string(2) 'of'
     *             [3] => string(4) 'tags'
     *         }
     *         ['description'] => string(29) 'Some comments about this link'
     *         ['dateCreated'] => int(1234567890)
     *         ['public'] => bool(true)
     *     }
     *     [1]=> array(7) {
     *         // ...
     *     }
     * }
     *
     * @param string $data    The encoded string containing Netscape bookmarks
     * @param array  $context An optional set of options for the decoder; see below
     *
     * The $context array is a simple key=>value array, with the following supported keys:
     *
     * keep_nested_tags: boolean
     *     Tag links with parent folder names
     *
     * normalize_dates: boolean
     *     Whether parsed dates are expected to fall within a given date/time interval
     *
     * date_range: string
     *     Delta used to compute the "acceptable" date/time interval
     *
     * @return array An associative array containing parsed links
     *
     * @throws \Exception
     */
    public function decode(string $data, array $context = []): array
    {
        $keepNestedTags = $context[self::KEEP_NESTED_TAGS] ?? $this->defaultContext[self::KEEP_NESTED_TAGS];
        $normalizeDates = $context[self::NORMALIZE_DATES] ?? $this->defaultContext[self::NORMALIZE_DATES];
        $dateRange = $context[self::DATE_RANGE] ?? $this->defaultContext[self::DATE_RANGE];

        $items = [];
        $folderTags = [];
        $groupedFolderTags = [];

        $lines = explode("\n", $this->sanitizeString($data));

        foreach ($lines as $lineNumber => $line) {
            $item = [
                'name'        => null,
                'image'       => null,
                'url'         => null,
                'tags'        => null,
                'description' => null,
                'dateCreated' => null,
                'public'      => null,
            ];

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
                array_pop($groupedFolderTags);
                // </DL> matched: stop using header value
                $folderTags = static::flattenTagsList($groupedFolderTags);
                $this->logger->debug('[#' . $lineNumber . '] Header ended: ' . implode(' ', $tag ?? []));
                continue;
            }

            if (preg_match('/<a/i', $line)) {
                // match bookmark url
                if (preg_match('/href="(.*?)"/i', $line, $href)) {
                    $item['url'] = $href[1] ? $href[1] : null;
                }
                $this->logger->debug(
                    sprintf('[#%s] %s', $lineNumber, $item['url'] ? 'URL found: ' . $item['url'] : 'Empty URL')
                );

                // match bookmark icon
                if (preg_match('/icon="(.*?)"/i', $line, $icon)) {
                    $item['image'] = $icon[1] ? $icon[1] : null;
                }
                $this->logger->debug(
                    sprintf(
                        '[#%s] %s',
                        $lineNumber,
                        $item['image'] ? 'ICON found: ' . substr($item['image'], 0, 50) . ' ...' : 'Empty ICON'
                    )
                );

                // match bookmark title
                if (preg_match('/<a.*?[^br]>(.*?)<\/a>/i', $line, $title)) {
                    $item['name'] = $title[1] ? $title[1] : null;
                }
                $this->logger->debug(
                    sprintf('[#%s] %s', $lineNumber, $item['name'] ? 'TITLE found: ' . $item['name'] : 'Empty TITLE')
                );

                // match bookmark note
                if (preg_match('/(description|note)="(.*?)"/i', $line, $note)) {
                    $note = $note[2];
                } elseif (preg_match('/<dd>(.*?)$/i', $line, $note)) {
                    // match bookmark note (alternative syntax)
                    $note = str_replace('<br>', "\n", $note[1]);
                }
                $item['description'] = $note ? $note : null;
                // phpcs:disable Generic.Files.LineLength
                $this->logger->debug(
                    sprintf(
                        '[#%s] %s',
                        $lineNumber,
                        $item['description'] ? 'DESCRIPTION found: ' . substr($item['description'], 0, 50) . ' ...' : 'Empty DESCRIPTION'
                    )
                );
                // phpcs:enable

                $tags = [];
                // merge nested tags
                if ($keepNestedTags) {
                    $tags = array_merge($tags, $folderTags);
                }

                // match bookmark tags
                if (preg_match('/(tags?|labels?|folders?)="(.*?)"/i', $line, $labels)) {
                    $separator = false !== strpos($labels[2], ',') ? ',' : ' ';
                    $tags = array_merge(
                        $tags,
                        static::splitTagString($labels[2], $separator)
                    );
                }
                $item['tags'] = $tags;

                // match bookmark date created
                if (preg_match('/add_date="(.*?)"/i', $line, $addDate)) {
                    $time = $this->parseDate($addDate[1], $normalizeDates, $dateRange);
                    $item['dateCreated'] = $time ? $time : null;
                }

                // phpcs:disable Generic.Files.LineLength
                $this->logger->debug(
                    sprintf(
                        '[#%s] %s',
                        $lineNumber,
                        $item['dateCreated'] ? 'DATE found: ' . $item['dateCreated'] : 'Empty DATE'
                    )
                );
                // phpcs:enable

                // match bookmark visibility
                if (preg_match('/(public|published|pub)="(.*?)"/i', $line, $public)) {
                    // bookmark visibility is public
                    $item['public'] = $this->parseBoolean($public[2]);
                } elseif (preg_match('/(private|shared)="(.*?)"/i', $line, $private)) {
                    // bookmark visibility is private (inverse values)
                    $item['public'] = !$this->parseBoolean($private[2]);
                }
                $this->logger->debug(
                    sprintf('[#%s] %s', $lineNumber, $item['public'] ? 'public' : 'private')
                );

                $this->logger->info('File parsing ended');
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Parses a formatted date.
     *
     * @see http://php.net/manual/en/datetime.formats.compound.php
     * @see http://php.net/manual/en/function.strtotime.php
     *
     * @param string $date           Formatted date
     * @param bool   $normalizeDates Normalize dates true or false
     * @param string $dateRange      String representing date range
     *
     * @return int Unix timestamp corresponding to a successfully parsed date,
     *             else current date and time
     *
     * @throws \Exception
     */
    public function parseDate(string $date, bool $normalizeDates, string $dateRange): int
    {
        if (strtotime('@' . $date)) {
            // Unix timestamp
            if ($normalizeDates) {
                $date = $this->normalizeDate($date, $dateRange);
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
     * Normalizes a date by supposing it is comprised in a given range.
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
     * @param string $dateRange String representing date range
     *
     * @return int Unix timestamp in seconds, within the expected range
     *
     * @throws \Exception
     */
    public function normalizeDate(string $epoch, string $dateRange): int
    {
        $date = new \DateTime('@' . $epoch);
        $maxDate = new \DateTime('+' . $dateRange);

        for ($i = 1; $date > $maxDate; ++$i) {
            // trim the provided date until it falls within the expected range
            $date = new \DateTime('@' . substr($epoch, 0, \strlen($epoch) - $i));
        }

        return $date->getTimestamp();
    }

    /**
     * Parses the value of a supposedly boolean attribute.
     *
     * @param string $value Attribute value to evaluate
     *
     * @return bool 'true' when the value is evaluated as true 'false' when the value is evaluated as false
     *              or the value is undefined
     */
    public function parseBoolean(string $value): bool
    {
        if (preg_match('/^(' . self::TRUE_PATTERN . ')$/i', $value)) {
            return true;
        }

        if (preg_match('/^(' . self::FALSE_PATTERN . ')$/i', $value)) {
            return false;
        }

        return false;
    }

    /**
     * Sanitizes the content of a string containing Netscape bookmarks.
     *
     * This removes:
     * - comment blocks
     * - metadata: DOCTYPE, H1, META, TITLE
     * - extra newlines, trailing spaces and tabs
     *
     * @param string $bookmark Original bookmark string
     *
     * @return string Sanitized bookmark string
     */
    public static function sanitizeString(string $bookmark): string
    {
        // remove comments
        $bookmark = preg_replace('@<!--.*?-->@mis', '', $bookmark);

        // keep one XML element per line to prepare for linear parsing
        $bookmark = preg_replace('@>(\s*?)<@mis', ">\n<", $bookmark);

        // remove unused metadata
        $bookmark = preg_replace('@(<!DOCTYPE|<META|<TITLE|<H1|<P).*\n@i', '', $bookmark);

        // trim whitespace
        $bookmark = trim($bookmark);

        // remove carriage returns
        $bookmark = str_replace("\r", '', $bookmark);

        // convert multiline descriptions to one-line descriptions
        // convert new line to <br>
        $bookmark = preg_replace_callback(
            '@<DD>(.*?)(</?(:?DT|DD|DL))@mis',
            function ($match) {
                return '<DD>' . str_replace("\n", '<br>', trim($match[1])) . PHP_EOL . $match[2];
            },
            $bookmark
        );

        // convert multiline descriptions inside <A> tags to one-line descriptions
        // convert new line to <br>
        $bookmark = preg_replace_callback(
            '@<A(.*?)</A>@mis',
            function ($match) {
                return '<A ' . str_replace("\n", '<br>', trim($match[1])) . '</A>';
            },
            $bookmark
        );

        // concatenate all data related to the same entry on the same line
        // e.g. <A HREF="...">My Link</A><DD>List<br>- item1<br>- item2
        $bookmark = preg_replace('@\n<br>@mis', '<br>', $bookmark);
        $bookmark = preg_replace('@\n<DD@i', '<DD', $bookmark);

        return $bookmark;
    }

    /**
     * Split tag string using provided separator.
     *
     * @param string $tagString Tag string
     * @param string $separator tag separator
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
     * Sanitizes a space-separated list of tags.
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
        $separator = false !== strpos($tagString, ',') ? ',' : ' ';
        $tags = static::splitTagString($tagString, $separator);

        foreach ($tags as $key => &$value) {
            if (ctype_alnum($value)) {
                continue;
            }

            $keepWhiteSpaces = ' ' !== $separator;

            $value = strtolower($value);

            // trim leading punctuation
            $value = preg_replace('/^[[:punct:]]/', '', $value);

            // trim all but alphanumeric characters, underscores and non-leading dashes
            $value = preg_replace('/[^\p{L}\p{N}\-_' . ($keepWhiteSpaces ? ' ' : '') . ']++/u', '', $value);

            if ('' == $value) {
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
        return array_reduce(
            $groupedTags,
            function (array $carry, array $item) {
                return array_merge($carry, $item);
            },
            []
        );
    }
}
