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

namespace Shaarli\NetscapeBookmarkParser\DataFormatter;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class BookmarksDataFormatter
{
    public const FORMAT = 'bookmarks';

    /**
     * Checks whether the formatter can handle given format.
     *
     * @param string $format
     *
     * @return bool
     */
    public function supportsFormatting(string $format): bool
    {
        return self::FORMAT === $format;
    }

    /**
     * Reorder bookmarks array by tag name and set default tag when missing.
     *
     * @param array $data
     *
     * @return array
     */
    public function format(array $data): array
    {
        if ([] === $data) {
            throw new \InvalidArgumentException('Array cannot be empty');
        }

        $tags = [];
        foreach ($data as $bookmark) {
            if (! isset($bookmark['tags'])) {
                $bookmark['tags'] = ['undefined'];
            }
            foreach ($bookmark['tags'] as $tagName) {
                $tags[$tagName][] = $bookmark;
            }
        }

        $data = [];
        foreach ($tags as $tagName => $bookmarks) {
            $data[] = [
                'name'      => $tagName,
                'bookmarks' => $bookmarks,
            ];
        }

        return $data;
    }
}
