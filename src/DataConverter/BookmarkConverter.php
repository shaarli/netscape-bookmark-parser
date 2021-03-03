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

namespace Shaarli\NetscapeBookmarkParser\DataConverter;

/**
 * Convert bookmark into legacy Shaarli format.
 *
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class BookmarkConverter extends AbstractConverter
{
    public const FORMAT = 'bookmark';

    public const MAP = [
        'url'         => 'uri',
        'image'       => 'icon',
        'name'        => 'title',
        'description' => 'note',
        'tags'        => 'tags',
        'dateCreated' => 'time',
        'public'      => 'pub',
    ];
}
