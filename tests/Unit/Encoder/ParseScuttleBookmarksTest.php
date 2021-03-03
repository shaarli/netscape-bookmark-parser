<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure Scuttle exports are properly parsed.
 *
 * @see https://sourceforge.net/projects/scuttle/
 */
class ParseScuttleBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name' => 'EuroVoc Thesaurus',
            'image'  => null,
            'url'   => 'http://eurovoc.europa.eu/drupal/?q=navigation&amp;cl=en',
            'tags'  => [
                'dictionary',
            ],
            'description'  => 'Multilingual Thesaurus of the European Union',
            'dateCreated'  => 1298020913,
            'public'   => null,
        ],
        [
            'name' => "IATE - The EU's multilingual term base",
            'image'  => null,
            'url'   => 'http://iate.europa.eu/iatediff/SearchByQueryLoad.do?method=load',
            'tags'  => [
                'dictionary',
            ],
            'description'  => null,
            'dateCreated'  => 1290688452,
            'public'   => null,
        ],
        [
            'name' => 'Linguee - Das Web als WÃ¶rterbuch - EN/DE, EN/FR, EN/SP, EN/POR',
            'image'  => null,
            'url'   => 'http://www.linguee.de/deutsch-englisch/search',
            'tags'  => [
                'dictionary',
            ],
            'description'  => '&quot;Durchsuchen Sie Millionen von SÃ¤tzen, die von anderen Menschen Ã¼bersetzt wurden.&quot;',
            'dateCreated'  => 1290691589,
            'public'   => null,
        ],
        [
            'name' => 'UN Terminology in German, English (&amp; French &amp; Spanish)',
            'image'  => null,
            'url'   => 'http://unterm.un.org/dgaacs/gts_term.nsf',
            'tags'  => [
                'dictionary',
            ],
            'description'  => "Database of the United Nation's German Translation Section. Every record contains at least one German term and a corresponding term usually in English. Most records also contain a French equivalent, some also a Spanish version. Not necessarily official.",
            'dateCreated'  => 1210915553,
            'public'   => null,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'Funky16Corners',
            'image'  => null,
            'url'   => 'http://funky16corners.com',
            'tags'  => [
                'funk',
                'musik',
                'blog',
            ],
            'description'  => 'The best in funk, soul, jazz and rare groove vinyl<br>I have been writing about music in various forms (zines, newspapers, e-zines, blogs) since the mid-80’s. The Funky16Corners blog started in November of 2004 to focus on funk and soul vinyl. Since mid-2006, in addition to individual MP3 tracks, I have been posting mixes under the title Funky16Corners radio. Most MP3s and mixes will be available for a few weeks.',
            'dateCreated'  => 1491107880,
            'public'   => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse bookmarks as exported by Scuttle.
     */
    public function testParse(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/scuttle.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse bookmarks as exported by Scuttle.
     */
    public function testParseWithNewLine(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/scuttle_new_line.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_2, $result);
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
