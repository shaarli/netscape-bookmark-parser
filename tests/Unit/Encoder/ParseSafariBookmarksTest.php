<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

use function file_get_contents;

/**
 * Ensure Safari exports are properly parsed.
 */
class ParseSafariBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED = [
        [
            'name' => 'GitHub',
            'image'  => null,
            'url'   => 'https://github.com/',
            'tags'  => [
                'favoris',
            ],
            'description'  => null,
            'dateCreated'  => null,
            'public'   => null,
        ],
        [
            'name' => 'GitHub - shaarli/Shaarli: The personal, minimalist, super-fast, database free, bookmarking service - community repo',
            'image'  => null,
            'url'   => 'https://github.com/shaarli/Shaarli',
            'tags'  => [
                'github',
                'shaarli',
            ],
            'description'  => null,
            'dateCreated'  => null,
            'public'   => null,
        ],
        [
            'name' => 'Wikipedia, the free encyclopedia',
            'image'  => null,
            'url'   => 'https://en.wikipedia.org/wiki/Main_Page',
            'tags'  => [
                'autre',
                'divers',
                'doc',
            ],
            'description'  => null,
            'dateCreated'  => null,
            'public'   => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse bookmarks as exported by Safari - Strip punctuation from folder names.
     */
    public function testParseFoldedStripPunctuation(): void
    {
        $content = file_get_contents(self::FIXTURE_DIRECTORY . 'input/safari_folded.htm');
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
