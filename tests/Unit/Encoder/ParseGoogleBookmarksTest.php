<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;

/**
 * Ensure Google Bookmarks exports are properly parsed.
 *
 * The reference data has been dumped with Google Bookmarks on 2018-10-01
 */
class ParseGoogleBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED = [
        [
            'name'        => 'WordHippo | Comprehensive Thesaurus for Synonyms and Antonyms',
            'image'       => null,
            'url'         => 'https://www.wordhippo.com/',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1515515697,
            'public'      => null,
        ],
        [
            'name'        => 'powershell - Move files into alphabetically named folders - Stack Overflow',
            'image'       => null,
            'url'         => 'https://stackoverflow.com/questions/20180072/move-files-into-alphabetically-named-folders',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1519067075,
            'public'      => null,
        ],
        [
            'name'        => 'Free Lien Search',
            'image'       => null,
            'url'         => 'http://www.searchq.com/',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1523996185,
            'public'      => null,
        ],
        [
            'name'        => 'OpenNIC Project',
            'image'       => null,
            'url'         => 'https://www.opennic.org/',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1529505663,
            'public'      => null,
        ],
        [
            'name'        => 'Kubo and the Two Strings (2016) - IMDb',
            'image'       => null,
            'url'         => 'https://www.imdb.com/title/tt4302938/',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1532442262,
            'public'      => null,
        ],
        [
            'name'        => 'Home | NextAce',
            'image'       => null,
            'url'         => 'https://nextace.com/',
            'tags'        => [
                'unlabeled',
            ],
            'description' => null,
            'dateCreated' => 1523996194,
            'public'      => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse nested Google Bookmarks (directories and subdirectories).
     */
    public function testParseNested(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/google_bookmarks_nested.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED, $result);
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
