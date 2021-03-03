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
 * @author "Matthias Morin" <mat@tangoman.io>
 */
abstract class AbstractConverter implements DataConverterInterface
{
    public const FORMAT = null;

    public const MAP = [];

    /**
     * {@inheritdoc}
     */
    public function supportsConversion(string $format): bool
    {
        return $this::FORMAT === $format;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(array $source): array
    {
        if ([] === $source) {
            throw new \InvalidArgumentException('Array cannot be empty');
        }

        $result = [];
        foreach ($this::MAP as $origin => $destination) {
            // ignore missing key from source array
            if (\array_key_exists($origin, $source)) {
                $result[$destination] = $source[$origin];
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseConvert(array $source): array
    {
        if ([] === $source) {
            throw new \InvalidArgumentException('Array cannot be empty');
        }

        $result = [];
        foreach ($this::MAP as $origin => $destination) {
            $result[$origin] = $source[$destination];
        }

        return $result;
    }
}
