<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure Shaarli exports are properly parsed.
 *
 * @see https://github.com/shaarli/Shaarli
 */
class ParseShaarliBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name' => "Kouign'amann recipes",
            'image'  => null,
            'url'   => '?lY47tw',
            'tags'  => [
                'breton',
                'recipe',
                'kouign',
                'amann',
                'traditional',
                'caramel',
                'butter',
            ],
            'description'  => "&quot;Is there anything more fabulous than something created through the wonder and miracle of caramelization?&quot;\n\n- http://www.davidlebovitz.com/2005/08/long-live-the-k/\n- http://www.bonappetit.com/recipe/kouign-amann\n\n&quot;It is strictly forbidden to think about diet while you're making a Kouign Amann&quot;",
            'dateCreated'  => 1459371397,
            'public'   => true,
        ],
        [
            'name' => 'The Most Important Object In Computer Graphics History Is This Teapot - Facts So Romantic - Nautilus',
            'image'  => null,
            'url'   => 'http://nautil.us/blog/the-most-important-object-in-computer-graphics-history-is-this-teapot',
            'tags'  => [
                'teapot',
                'computer',
                'generation',
                'graphics',
                '3d',
            ],
            'description'  => null,
            'dateCreated'  => 1459371358,
            'public'   => true,
        ],
        [
            'name' => 'PHP - Testing Your Privates',
            'image'  => null,
            'url'   => 'https://sebastian-bergmann.de/archives/881-Testing-Your-Privates.html',
            'tags'  => [
                'php',
                'class',
                'test',
                'unitary',
                'private',
            ],
            'description'  => null,
            'dateCreated'  => 1459371224,
            'public'   => false,
        ],
        [
            'name' => 'Mine Turtle Instructions by StormL on DeviantArt',
            'image'  => null,
            'url'   => 'http://storml.deviantart.com/art/Mine-Turtle-Instructions-302477240?q=in%3Ascraps%20sort%3Atime%20gallery%3Astorml&amp;qo=1',
            'tags'  => [
                'mine',
                'turtle',
                'asdf',
                'paper',
                'craft',
            ],
            'description'  => 'Schematics: http://www.deviantart.com/users/outgoing?http://www.mediafire.com/?bx19xdd95ed4ap6',
            'dateCreated'  => 1459371140,
            'public'   => true,
        ],
        [
            'name' => ' Shaarli: the personal, minimalist, super-fast, no-database delicious clone',
            'image'  => null,
            'url'   => 'https://github.com/shaarli/Shaarli/wiki',
            'tags'  => [
                'opensource',
                'software',
            ],
            'description'  => "Welcome to Shaarli! This is your first public bookmark. To edit or delete me, you must first login.\n\nTo learn how to use Shaarli, consult the link &quot;Help/documentation&quot; at the bottom of this page.\n\nYou use the community supported version of the original Shaarli project, by Sebastien Sauvage.",
            'dateCreated'  => 1459370973,
            'public'   => true,
        ],
        [
            'name' => 'My secret stuff... - Pastebin.com',
            'image'  => null,
            'url'   => 'http://sebsauvage.net/paste/?8434b27936c09649#bR7XsXhoTiLcqCpQbmOpBi3rq2zzQUC5hBI7ZT1O3x8=',
            'tags'  => [
                'secretstuff',
            ],
            'description'  => "Shhhh! I'm a private link only YOU can see. You can delete me too.",
            'dateCreated'  => 1459370913,
            'public'   => false,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'Markdown - code',
            'image'  => null,
            'url'   => '?Z-mb0g',
            'tags'  => [
                'markdown',
                'php',
                'code',
            ],
            'description'  => "PHP stuff:\n\n    &lt;?php\n    phpinfo();\n    ?&gt;\n\nPython stuff:\n\n    import logging\n    import os\n\n    if __name__ == '__main__':\n        logging.info(&quot;Current directory: %s&quot;, os.getcwd())",
            'dateCreated'  => 1463262544,
            'public'   => true,
        ],
        [
            'name' => 'Markdown - lists',
            'image'  => null,
            'url'   => '?9PvbnA',
            'tags'  => [
                'markdown',
            ],
            'description'  => "Standard:\n* item1\n* item2\n* item3\n\nNested:\n- item1\n    - item1.1\n    - item1.2\n- item2",
            'dateCreated'  => 1463262338,
            'public'   => true,
        ],
        [
            'name' => 'Markdown - headers and quotes',
            'image'  => null,
            'url'   => '?GIvbSw',
            'tags'  => [
                'markdown',
            ],
            'description'  => "A First Level Header\n====================\n\nA Second Level Header\n---------------------\n\nNow is the time for all good men to come to\nthe aid of their country. This is just a\nregular paragraph.\n\nThe quick brown fox jumped over the lazy\ndog's back.\n\n### Header 3\n\n&gt; This is a blockquote.\n&gt; \n&gt; This is the second paragraph in the blockquote.\n&gt;\n&gt; ## This is an H2 in a blockquote",
            'dateCreated'  => 1463262269,
            'public'   => true,
        ],
    ];
    // phpcs:enable

    public const EXPECTED_3 = [
        [
            'name' => 'A Pen by Rodrigo Muniz.',
            'image'  => null,
            'url'   => 'https://gist.github.com/rodrigomuniz/8408734',
            'tags'  => [
                'css',
            ],
            'description'  => 'simple on/off button',
            'dateCreated'  => 1470640652,
            'public'   => false,
        ],
        [
            'name' => 'URL Rewriting for Beginners - Web Development in Brighton - Added Bytes',
            'image'  => null,
            'url'   => 'https://www.addedbytes.com/articles/for-beginners/url-rewriting-for-beginners/',
            'tags'  => [
                'apache',
            ],
            'description'  => null,
            'dateCreated'  => 1469950052,
            'public'   => true,
        ],
    ];

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse bookmarks as exported by Shaarli - no plugin enabled.
     */
    public function testParseNoPlugins(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/shaarli.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse bookmarks as exported by Shaarli - Markdown plugin enabled.
     */
    public function testParseMarkdown(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/shaarli_markdown.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_2, $result);
    }

    /**
     * Parse bookmarks as exported by Shaarli legacy.
     */
    public function testParseLegacy(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/shaarli_legacy.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_3, $result);
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
