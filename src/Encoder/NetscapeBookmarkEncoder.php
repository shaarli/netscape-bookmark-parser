<?php

declare(strict_types=1);

/*
 * This file is part of the Shaarli Netscape Bookmark Parser package.
 *
 * (c) "Matthias Morin" <mat@tangoman.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shaarli\NetscapeBookmarkParser\Encoder;

/**
 * This encoder will export array to a flat Netscape-bookmark-file.
 *
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class NetscapeBookmarkEncoder
{
    public const FORMAT = 'netscape';

    // phpcs:disable Generic.Files.LineLength
    public const HEADER = "<!DOCTYPE NETSCAPE-Bookmark-file-1>\n<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\">\n<TITLE>Bookmarks</TITLE>\n<H1>Bookmarks</H1>\n<DL><p>\n";
    // phpcs:enable

    /**
     * Checks whether the serializer can encode to given format.
     *
     * @param string $format Format name
     *
     * @return bool
     */
    public function supportsEncoding(string $format): bool
    {
        return self::FORMAT === $format;
    }

    /**
     * Encodes data into the given format.
     *
     * @param mixed $data    Data to encode
     * @param array $context Options that normalizers/encoders have access to
     *
     * @return string
     */
    public function encode($data, array $context = []): string
    {
        if (!\is_array($data)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 1 passed to %s::%s must be of type array, %s given',
                    self::class,
                    __FUNCTION__,
                    \gettype($data)
                )
            );
        }

        $result = self::HEADER;
        foreach ($data as $tag) {
            $result .= '<DT><H3';
            if ($tag['dateCreated'] ?? null) {
                $result .= sprintf(' ADD_DATE="%s"', $tag['dateCreated']);
            }
            if ($tag['dateModified'] ?? null) {
                $result .= sprintf(' LAST_MODIFIED="%s"', $tag['dateModified']);
            }
            $result .= sprintf(">%s</H3>\n<DL><p>\n", $tag['name']);
            foreach ($tag['bookmarks'] as $bookmark) {
                $result .= sprintf('<DT><A HREF="%s"', $bookmark['url']);
                if ($bookmark['dateCreated'] ?? null) {
                    $result .= sprintf('> ADD_DATE="%s"', $bookmark['dateCreated']);
                }
                if ($bookmark['public'] ?? null) {
                    $result .= sprintf(' PRIVATE="%s"', $bookmark['public'] ? '0' : '1');
                }
                if ($bookmark['dateModified'] ?? null) {
                    $result .= sprintf(' LAST_MODIFIED="%s"', $bookmark['dateModified']);
                }
                if ($bookmark['image'] ?? null) {
                    $result .= sprintf(' ICON="%s"', $bookmark['image']);
                }
                $result .= sprintf(">%s</A>\n", $bookmark['name']);
                if ($bookmark['description'] ?? null) {
                    $result .= sprintf("<DD>%s\n", $bookmark['description']);
                }
            }
            $result .= "<\DL><p>\n";
        }
        $result .= "<\DL><p>\n";

        return $result;
    }
}
