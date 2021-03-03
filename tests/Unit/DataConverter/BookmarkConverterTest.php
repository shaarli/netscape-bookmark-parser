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

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\DataConverter\BookmarkConverter;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class BookmarkConverterTest extends TestCase
{
    private const ORIGIN = [
        'url'         => 'https://tangoman.io',
        'image'       => 'data:image/png;base64,FOOBAR',
        'name'        => 'example',
        'description' => 'this is an example bookmark',
        'tags'        => [
            'example_1',
            'example_2',
        ],
        'dateCreated' => 123456789,
        'public'      => true,
    ];

    private const DESTINATION = [
        'uri'   => 'https://tangoman.io',
        'icon'  => 'data:image/png;base64,FOOBAR',
        'title' => 'example',
        'note'  => 'this is an example bookmark',
        'tags'  => [
            'example_1',
            'example_2',
        ],
        'time'  => 123456789,
        'pub'   => true,
    ];

    /**
     * @var BookmarkConverter
     */
    private $bookmarkDataConverter;

    // --------------------------------------------------
    // Business Logic
    // --------------------------------------------------

    public function testSupportsShouldReturnExpectedBoolean(): void
    {
        $result = $this->bookmarkDataConverter->supportsConversion('foobar');

        $this->assertFalse($result);

        $result = $this->bookmarkDataConverter->supportsConversion('bookmark');

        $this->assertTrue($result);
    }

    public function testConvertShouldReturnExpectedResult(): void
    {
        $result = $this->bookmarkDataConverter->convert(self::ORIGIN);

        $this->assertSame(self::DESTINATION, $result);
    }

    public function testReverseConvertShouldReturnExpectedResult(): void
    {
        $result = $this->bookmarkDataConverter->reverseConvert(self::DESTINATION);

        $this->assertSame(self::ORIGIN, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->bookmarkDataConverter = new BookmarkConverter();
    }

    protected function tearDown(): void
    {
        $this->bookmarkDataConverter = null;
    }
}
