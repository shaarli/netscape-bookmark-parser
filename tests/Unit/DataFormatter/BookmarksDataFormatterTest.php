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

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\DataFormatter;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\DataFormatter\BookmarksDataFormatter;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class BookmarksDataFormatterTest extends TestCase
{
    private const FIXTURE_1 = [
        [
            'name' => 'missing tag',
        ],
        [
            'name' => 'tango',
            'tags' => ['foo'],
        ],
        [
            'name' => 'tangoman',
            'tags' => ['bar'],
        ],
        [
            'name' => 'foobar',
            'tags' => [
                'foo',
                'bar',
            ],
        ],
    ];

    private const EXPECTED_1 = [
        [
            'name'      => 'undefined',
            'bookmarks' => [
                [
                    'name' => 'missing tag',
                    'tags' => [
                        'undefined',
                    ],
                ],
            ],
        ],
        [
            'name'      => 'foo',
            'bookmarks' => [
                [
                    'name' => 'tango',
                    'tags' => [
                        'foo',
                    ],
                ],
                [
                    'name' => 'foobar',
                    'tags' => [
                        'foo',
                        'bar',
                    ],
                ],
            ],
        ],
        [
            'name'      => 'bar',
            'bookmarks' => [
                [
                    'name' => 'tangoman',
                    'tags' => [
                        'bar',
                    ],
                ],
                [
                    'name' => 'foobar',
                    'tags' => [
                        'foo',
                        'bar',
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var BookmarksDataFormatter|null
     */
    private $bookmarksDataFormatter;

    // --------------------------------------------------
    // Exception
    // --------------------------------------------------

    public function testFormatEmptyArrayShouldRaiseException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array cannot be empty');

        $this->bookmarksDataFormatter->format([]);
    }

    // --------------------------------------------------
    // Business Logic
    // --------------------------------------------------

    public function testSupportsShouldReturnExpectedBoolean(): void
    {
        $result = $this->bookmarksDataFormatter->supportsFormatting('foobar');

        $this->assertFalse($result);

        $result = $this->bookmarksDataFormatter->supportsFormatting('bookmarks');

        $this->assertTrue($result);
    }

    public function testFormatShouldReturnExpectedResult(): void
    {
        $result = $this->bookmarksDataFormatter->format(self::FIXTURE_1);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->bookmarksDataFormatter = new BookmarksDataFormatter();
    }

    protected function tearDown(): void
    {
        $this->bookmarksDataFormatter = null;
    }
}
