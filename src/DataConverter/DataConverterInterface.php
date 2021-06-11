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
 * Renames keys from source normalized object with given MAP array.
 *
 * @author "Matthias Morin" <mat@tangoman.io>
 */
interface DataConverterInterface
{
    /**
     * Checks whether the converter can handle given format.
     *
     * @param string $format Target format
     *
     * @return bool
     */
    public function supportsConversion(string $format): bool;

    /**
     * Convert source array to destination format.
     *
     * @param array $source Source array to be converted
     *
     * @return array
     */
    public function convert(array $source): array;

    /**
     * Reverse convert back to original array.
     *
     * @param array $source Source array to be converted again
     *
     * @return array
     */
    public function reverseConvert(array $source): array;
}
