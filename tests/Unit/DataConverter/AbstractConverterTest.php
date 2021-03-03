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

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\DataConverter;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\DataConverter\AbstractConverter;
use Shaarli\NetscapeBookmarkParser\DataConverter\DataConverterInterface;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class AbstractConverterTest extends TestCase
{
    private const ORIGIN = [
        'origin_foo' => 'foo',
        'origin_bar' => 'bar',
        'origin_baz' => 'baz',
    ];

    private const DESTINATION = [
        'destination_foo' => 'foo',
        'destination_bar' => 'bar',
        'destination_baz' => 'baz',
    ];

    /**
     * @var DataConverterInterface
     */
    private $abstractConverter;

    // --------------------------------------------------
    // Exception
    // --------------------------------------------------

    public function testConvertEmptyArrayShouldRaiseException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Array cannot be empty');

        $this->abstractConverter->convert([]);
    }

    public function testReverseConvertEmptyArrayShouldRaiseException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Array cannot be empty');

        $this->abstractConverter->reverseConvert([]);
    }

    // --------------------------------------------------
    // Business Logic
    // --------------------------------------------------

    public function testConvertShouldReturnExpectedResult(): void
    {
        $result = $this->abstractConverter->convert(self::ORIGIN);

        $this->assertSame(self::DESTINATION, $result);
    }

    public function testReverseConvertShouldReturnExpectedResult(): void
    {
        $result = $this->abstractConverter->reverseConvert(self::DESTINATION);

        $this->assertSame(self::ORIGIN, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        // create a new anonymous instance from the Abstract Class
        $this->abstractConverter = new class () extends AbstractConverter {
            public const MAP = [
                'origin_foo' => 'destination_foo',
                'origin_bar' => 'destination_bar',
                'origin_baz' => 'destination_baz',
            ];
        };
    }

    protected function tearDown(): void
    {
        $this->abstractConverter = null;
    }
}
