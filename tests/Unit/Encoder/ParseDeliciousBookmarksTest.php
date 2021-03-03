<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure Delicious exports are properly parsed.
 *
 * @see http://delicious.com/
 */
class ParseDeliciousBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name' => 'Export Firefox bookmarks to backup or transfer',
            'image'  => null,
            'url'   => 'https://support.mozilla.org/en-US/kb/export-firefox-bookmarks-to-backup-or-transfer',
            'tags'  => [
                'firefox',
                'bookmark',
                'export',
            ],
            'description'  => 'Export your bookmarks to an HTML file, which can be used as a backup or for importing into another web browser',
            'dateCreated'  => 1098309600,
            'public'   => true,
        ],
        [
            'name' => 'Netscape Bookmark File Format',
            'image'  => null,
            'url'   => 'https://msdn.microsoft.com/en-us/library/aa753582%28v=vs.85%29.aspx',
            'tags'  => [
                'netscape',
                'xml',
                'bookmark',
                'format',
            ],
            'description'  => 'Windows Internet Explorer Favorites file format',
            'dateCreated'  => 1268866800,
            'public'   => true,
        ],
        [
            'name' => 'PHP - Testing your privates',
            'image'  => null,
            'url'   => 'https://sebastian-bergmann.de/archives/881-Testing-Your-Privates.html',
            'tags'  => [
                'php',
                'test',
                'private',
            ],
            'description'  => null,
            'dateCreated'  => 1265670000,
            'public'   => false,
        ],
        [
            'name' => 'Paper craft Mine Turtle',
            'image'  => null,
            'url'   => 'http://storml.deviantart.com/art/Mine-Turtle-Instructions-302477240?q=in%3Ascraps%20sort%3Atime%20gallery%3Astorml&qo=1',
            'tags'  => [
                'mine',
                'turtle',
                'paper',
                'craft',
                'asdf',
            ],
            'description'  => '"Hello!"',
            'dateCreated'  => 1428876000,
            'public'   => true,
        ],
        [
            'name' => 'fontfamily.io',
            'image'  => null,
            'url'   => 'http://fontfamily.io/',
            'tags'  => [
                '@font-face',
                'os',
                'typography',
            ],
            'description'  => 'Compatibility tables for default local fonts.',
            'dateCreated'  => 1412085559,
            'public'   => true,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'spip pastebin - outil de debug collaboratif - Bonjour les écureuils !',
            'image'  => null,
            'url'   => 'http://spip.pastebin.fr/28921',
            'tags'  => [
                'spip3',
                'astuces',
            ],
            'description'  => "Text\n<li>#CLE ---> #VALEUR</li>\n</BOUCLE_exploiter>\n</code>",
            'dateCreated'  => 1380651656,
            'public'   => true,
        ],
        [
            'name' => 'Changer le monde - Carnets Web de La Grange',
            'image'  => null,
            'url'   => 'http://www.la-grange.net/2013/09/07/changement',
            'tags'  => [
                'culture',
                'propriété_intellectuelle',
                'changerlemonde',
            ],
            'description'  => "La juxtaposition des mots propriétés et intellectuel (du monde des idées) est une aberration dans un contexte de l'échange et de la culture.",
            'dateCreated'  => 1380651611,
            'public'   => true,
        ],
    ];
    // phpcs:enable


    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse bookmarks as exported by Delicious.
     */
    public function testParse(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/delicious.htm');
        $result = $this->decoder->decode($content);

        $this->assertEquals(self::EXPECTED_1, $result);
    }

    /**
     * Make sure that the sanitizing function doesn't strip content.
     */
    public function testParseStrictSanitizing(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/delicious_sanitize.htm');
        $result = $this->decoder->decode($content);

        $this->assertEquals(self::EXPECTED_2, $result);
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
