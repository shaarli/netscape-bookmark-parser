<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Shaarli\NetscapeBookmarkParser\DataFormatter\BookmarksDataFormatter;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkEncoder;

/**
 * Generic Netscape bookmark parser
 */
class NetscapeBookmarkParser
{
    public const DEPRECATION_VERSION = '4.0';

    private $defaultContext = [
        NetscapeBookmarkDecoder::KEEP_NESTED_TAGS => true,
        NetscapeBookmarkDecoder::NORMALIZE_DATES  => true,
        NetscapeBookmarkDecoder::DATE_RANGE       => '30 years',
    ];

    /**
     * @var LoggerInterface instance.
     */
    private $logger;

    /**
     * @var NetscapeBookmarkDecoder
     */
    private $decoder;

    /**
     * @var BookmarksDataFormatter
     */
    private $formatter;

    /**
     * @var NetscapeBookmarkEncoder
     */
    private $encoder;

    /**
     * This is the main entrypoint for the parser.
     *
     * It is only a wrapper around NetscapeBookmarkEncoder and NetscapeBookmarkDecoder
     * provided as a temporary compatibility layer for applications using the previous parser.
     * Most methods here are deprecated as it is recommended to implement Encoder and Decoder
     * directly for your use case.
     *
     * @param array                $defaultContext
     * @param LoggerInterface|null $logger
     */
    public function __construct(array $defaultContext = [], LoggerInterface $logger = null)
    {
        $this->defaultContext = array_merge($this->defaultContext, $defaultContext);
        $this->logger = $logger ?? new NullLogger();

        $this->decoder = new NetscapeBookmarkDecoder($this->defaultContext, $this->logger);
        $this->formatter = new BookmarksDataFormatter();
        $this->encoder = new NetscapeBookmarkEncoder();
    }

    /**
     * Parses a Netscape bookmark file
     *
     * @param string $filePath Bookmark file to parse
     *
     * @return array An associative array containing parsed links
     * @throws \Exception
     */
    public function parseFile(string $filePath): array
    {
        $this->logger->info('Starting to parse ' . $filePath);

        return $this->decoder->decode(file_get_contents($filePath));
    }

    /**
     * Exports data to Netscape bookmark format file
     *
     * @param array  $data
     * @param string $filePath
     *
     * @return string A string containing serialized data
     */
    public function export(array $data, string $filePath): string
    {
        $this->logger->info('Export to ' . $filePath);

        $data = $this->formatter->format($data);

        $data = $this->encoder->encode($data);

        file_put_contents($filePath, $data);

        return $data;
    }

    /**
     * Parses a string containing Netscape-formatted bookmarks
     *
     * @param string $data
     *
     * @return array
     * @throws \Exception
     */
    public function parseString(string $data): array
    {
        return $this->decoder->decode($data);
    }

    /**
     * @deprecated
     */
    public function parseDate(string $date, bool $normalizeDates, string $dateRange): int
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return $this->decoder->parseDate($date, $normalizeDates, $dateRange);
    }

    /**
     * @deprecated
     */
    public function normalizeDate(string $epoch, string $dateRange): int
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return $this->decoder->normalizeDate($epoch, $dateRange);
    }

    /**
     * @deprecated
     */
    public function parseBoolean(string $value): bool
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return $this->decoder->parseBoolean($value);
    }

    /**
     * @deprecated
     */
    public static function sanitizeString(string $bookmark): string
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return NetscapeBookmarkDecoder::sanitizeString($bookmark);
    }

    /**
     * @deprecated
     */
    public static function splitTagString(string $tagString, string $separator): array
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return NetscapeBookmarkDecoder::splitTagString($tagString, $separator);
    }

    /**
     * @deprecated
     */
    public static function sanitizeTags(string $tagString): array
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return NetscapeBookmarkDecoder::sanitizeTags($tagString);
    }

    /**
     * @deprecated
     */
    public static function flattenTagsList(array $groupedTags): array
    {
        @trigger_error(
            sprintf(
                'Method "%s()" is deprecated and will be removed in version %s',
                __FUNCTION__,
                self::DEPRECATION_VERSION,
            ),
            \E_USER_DEPRECATED
        );

        return NetscapeBookmarkDecoder::flattenTagsList($groupedTags);
    }
}
