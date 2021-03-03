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
 * Convert legacy Shaarli bookmark into new format.
 *
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class LegacyBookmarkConverter extends AbstractConverter
{
    public const FORMAT = 'bookmark:legacy';

    public const MAP = [
        'uri'   => 'url',
        'icon'  => 'image',
        'title' => 'name',
        'note'  => 'description',
        'tags'  => 'tags',
        'time'  => 'dateCreated',
        'pub'   => 'public',
    ];
}
