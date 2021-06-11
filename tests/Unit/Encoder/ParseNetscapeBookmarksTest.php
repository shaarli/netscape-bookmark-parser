<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure basic Netscape bookmarks are properly parsed.
 *
 * @see https://msdn.microsoft.com/en-us/library/aa753582%28v=vs.85%29.aspx
 * @see http://www.w3schools.com/tags/tag_dl.asp
 */
class ParseNetscapeBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    public const EXPECTED_1 = [
        [
            'name' => 'Secret stuff',
            'image'  => null,
            'url'   => 'https://private.tld',
            'tags'  => [
                'private',
                'secret',
            ],
            'description'  => "Super-secret stuff you're not supposed to know about",
            'dateCreated'  => 971175336,
            'public'   => false,
        ],
        [
            'name' => 'Public stuff',
            'image'  => null,
            'url'   => 'http://public.tld',
            'tags'  => [
                'public',
                'hello',
                'world',
            ],
            'description'  => null,
            'dateCreated'  => 1456433748,
            'public'   => true,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'Multiline desc',
            'image'  => null,
            'url'   => 'http://multi.li.ne/1',
            'tags'  => [
                'multi',
            ],
            'description'  => "List:\n- item1\n- item2\n- item3",
            'dateCreated'  => 1456433741,
            'public'   => true,
        ],
        [
            'name' => 'Multiline desc',
            'image'  => null,
            'url'   => 'http://multi.li.ne/2',
            'tags'  => [
                'multi',
            ],
            'description'  => "Nested lists:\n- list1\n  - item1.1\n  - item1.2\n  - item1.3\n- list2\n  - item2.1",
            'dateCreated'  => 1456433742,
            'public'   => true,
        ],
        [
            'name' => 'Multiline desc',
            'image'  => null,
            'url'   => 'http://multi.li.ne/3',
            'tags'  => [
                'multi',
            ],
            'description'  => "List:\n- item1\n- item2\n\nParagraph number one.\n\nParagraph\nnumber\ntwo.",
            'dateCreated'  => 1456433747,
            'public'   => true,
        ],
    ];

    public const EXPECTED_3 = [
        [
            'name' => 'Nested 1',
            'image'  => null,
            'url'   => 'http://nest.ed/1',
            'tags'  => [
                'tag1',
                'tag2',
                'multi word',
            ],
            'description'  => null,
            'dateCreated'  => 1456433741,
            'public'   => true,
        ],
        [
            'name' => 'Nested 1-1',
            'image'  => null,
            'url'   => 'http://nest.ed/1-1',
            'tags'  => [
                'folder1',
                'the first',
                'folder to encounter',
                'tag1',
                'tag2',
                'multi word',
            ],
            'description'  => null,
            'dateCreated'  => 1456433742,
            'public'   => true,
        ],
        [
            'name' => 'Nested 1-2',
            'image'  => null,
            'url'   => 'http://nest.ed/1-2',
            'tags'  => [
                'folder1',
                'the first',
                'folder to encounter',
                'tag3',
                'tag4',
                'leaf multi word',
            ],
            'description'  => null,
            'dateCreated'  => 1456433747,
            'public'   => true,
        ],
        [
            'name' => 'Nested 2-1',
            'image'  => null,
            'url'   => 'http://nest.ed/2-1',
            'tags'  => [
                'folder2',
            ],
            'description'  => 'First link of the second section',
            'dateCreated'  => 1454433742,
            'public'   => true,
        ],
        [
            'name' => 'Nested 2-2',
            'image'  => null,
            'url'   => 'http://nest.ed/2-2',
            'tags'  => [
                'folder2',
            ],
            'description'  => 'Second link of the second section',
            'dateCreated'  => 1453233747,
            'public'   => true,
        ],
        [
            'name' => 'Nested 3-1',
            'image'  => null,
            'url'   => 'http://nest.ed/3-1',
            'tags'  => [
                'folder3',
                'folder3-1',
                'tag3',
            ],
            'description'  => null,
            'dateCreated'  => 1454433742,
            'public'   => true,
        ],
        [
            'name' => 'Nested 3-2',
            'image'  => null,
            'url'   => 'http://nest.ed/3-2',
            'tags'  => [
                'folder3',
                'folder3-1',
            ],
            'description'  => null,
            'dateCreated'  => 1453233747,
            'public'   => true,
        ],
        [
            'name' => 'Nested 2',
            'image'  => null,
            'url'   => 'http://nest.ed/2',
            'tags'  => [
                'tag4',
            ],
            'description'  => null,
            'dateCreated'  => 1456733741,
            'public'   => true,
        ],
    ];

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_4 = [
        [
            'name' => 'The hunt for the fish pirates who exploit the sea - BBC Future',
            'image'  => null,
            'url'   => 'https://www.bbc.com/future/article/20190213-the-dramatic-hunt-for-the-fish-pirates-exploiting-our-seas',
            'tags'  => [
                'story',
                'oceans',
            ],
            'description'  => "For 10 years, a rogue fishing vessel and its crew plundered the world’s oceans, escaping repeated attempts of capture. Then a dramatic pursuit finally netted the one that got away.\n<A href=\"http://localhost.localdomain:8083/Shaarli/?JVvqCA\">\n<img src=\"http://localhost.localdomain:8083/Shaarli/cache/thumb/290ccda0deea6083ee613d358446103e/c975558ad43acdbd982ffafd8c01163d6c9ec5ca125901.jpg\"/>\n</A>",
            'dateCreated'  => 1591451445,
            'public'   => false,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse a basic Netscape file.
     */
    public function testParseBasic(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/netscape_basic.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse a Netscape file containing multiline descriptions.
     */
    public function testParseMultilineDescriptions(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/netscape_multiline.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_2, $result);
    }

    /**
     * Parse bookmarks nested in folders.
     */
    public function testParseNested(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/netscape_nested.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_3, $result);
    }

    /**
     * Leave links with no/empty tag as-is.
     */
    public function testEmptyDefaultTag(): void
    {
        $content = '<A HREF="http://no.tag">NoTag</A>';
        $result = $this->decoder->decode($content);

        $expected = [
            [
                'name' => 'NoTag',
                'image'  => null,
                'url'   => 'http://no.tag',
                'tags'  => [],
                'description'  => null,
                'dateCreated'  => null,
                'public'   => null,
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Keep empty tags.
     */
    public function testParseEmptyTags(): void
    {
        $content = '<A HREF="http://empty.tag" TAGS="">EmptyTag</A>';
        $result = $this->decoder->decode($content);

        $expected = [
            [
                'name' => 'EmptyTag',
                'image'  => null,
                'url'   => 'http://empty.tag',
                'tags'  => [],
                'description'  => null,
                'dateCreated'  => null,
                'public'   => null,
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Parse space-separated tags.
     */
    public function testParseSpaceTags(): void
    {
        $content = '<A HREF="http://space.tag" TAGS="t1 t2">SpaceTag</A>';
        $result = $this->decoder->decode($content);

        $expected = [
            [
                'name' => 'SpaceTag',
                'image'  => null,
                'url'   => 'http://space.tag',
                'tags'  => [
                    't1',
                    't2',
                ],
                'description'  => null,
                'dateCreated'  => null,
                'public'   => null,
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Parse comma-separated tags.
     */
    public function testParseCommaTags(): void
    {
        $content = '<A HREF="http://comma.tag" TAGS="t1,t2,t3">CommaTag</A>';
        $result = $this->decoder->decode($content);

        $expected = [
            [
                'name' => 'CommaTag',
                'image'  => null,
                'url'   => 'http://comma.tag',
                'tags'  => [
                    't1',
                    't2',
                    't3',
                ],
                'description'  => null,
                'dateCreated'  => null,
                'public'   => null,
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /**
     * Parse a extended Netscape file from Shaarli.
     */
    public function testParseExtended(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/netscape_extended.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_4, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->decoder = new NetscapeBookmarkDecoder();
    }

    protected function tearDown(): void
    {
        $this->decoder = null;
    }
}
