<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure Internet Explorer bookmarks are properly parsed.
 *
 * The reference data has been dumped with IE 11
 */
class ParseInternetExplorerBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name' => 'A better git log (Example)  Coderwall',
            'image'  => null,
            'url'   => 'https://coderwall.com/p/euwpig/a-better-git-log',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267453,
            'public'   => null,
        ],
        [
            'name' => 'Authentication Cheat Sheet - OWASP',
            'image'  => null,
            'url'   => 'https://www.owasp.org/index.php/Authentication_Cheat_Sheet',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271589,
            'public'   => null,
        ],
        [
            'name' => 'CSS 3D Clouds',
            'image'  => null,
            'url'   => 'https://www.clicktorelease.com/code/css3dclouds/#',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466270244,
            'public'   => null,
        ],
        [
            'name' => 'Dealing with line endings - User Documentation',
            'image'  => null,
            'url'   => 'https://help.github.com/articles/dealing-with-line-endings/#platform-all',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269537,
            'public'   => null,
        ],
        [
            'name' => 'Documentation of Album Covers Recreated with MS Paint',
            'image'  => null,
            'url'   => 'http://www.publiccollectors.org/MSPaintAlbumCovers.htm',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267067,
            'public'   => null,
        ],
        [
            'name' => 'Excuses For Lazy Coders',
            'image'  => null,
            'url'   => 'http://developerexcuses.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267083,
            'public'   => null,
        ],
        [
            'name' => 'Fifty Shades of Grey text generator  Parody erotic fiction generated algorithmically.',
            'image'  => null,
            'url'   => 'http://www.xwray.com/fiftyshades',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466266989,
            'public'   => null,
        ],
        [
            'name' => 'GitHub - originell-django-kittenstorage Django Storage Engine which returns images of kittens if files could not be found.',
            'image'  => null,
            'url'   => 'https://github.com/originell/django-kittenstorage',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267009,
            'public'   => null,
        ],
        [
            'name' => 'Heroic Programming',
            'image'  => null,
            'url'   => 'http://c2.com/cgi/wiki?HeroicProgramming',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466266984,
            'public'   => null,
        ],
        [
            'name' => 'Hg Init a Mercurial tutorial by Joel Spolsky',
            'image'  => null,
            'url'   => 'http://hginit.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271584,
            'public'   => null,
        ],
        [
            'name' => 'http--www.brendangregg.com-Specials-mkzombie.c',
            'image'  => null,
            'url'   => 'http://www.brendangregg.com/Specials/mkzombie.c',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267047,
            'public'   => null,
        ],
        [
            'name' => 'It Never works with cats...',
            'image'  => null,
            'url'   => 'http://lizclimo.tumblr.com/post/132165201759/bonus-comic-for-national-cat-day',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271425,
            'public'   => null,
        ],
        [
            'name' => 'Learn to write Gallifreyan in 9 simple steps',
            'image'  => null,
            'url'   => 'http://io9.gizmodo.com/learn-to-write-gallifreyan-in-9-simple-steps-506989915',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269580,
            'public'   => null,
        ],
        [
            'name' => 'Let me google that for you',
            'image'  => null,
            'url'   => 'http://lmgtfy.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271385,
            'public'   => null,
        ],
        [
            'name' => 'PHP Sadness',
            'image'  => null,
            'url'   => 'http://phpsadness.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269615,
            'public'   => null,
        ],
        [
            'name' => 'TEDxZurich - Jojo Mayer - Exploring the distance between 0 and 1 - YouTube',
            'image'  => null,
            'url'   => 'https://www.youtube.com/watch?v=KExLCJAuTXA',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269520,
            'public'   => null,
        ],
        [
            'name' => 'UserFriendly - Web Designer',
            'image'  => null,
            'url'   => 'http://ars.userfriendly.org/cartoons/?id=19971206',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267119,
            'public'   => null,
        ],
        [
            'name' => 'XKCD Plots in Matplotlib Going the Whole Way',
            'image'  => null,
            'url'   => 'http://jakevdp.github.io/blog/2013/07/10/XKCD-plots-in-matplotlib/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271475,
            'public'   => null,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'It Never works with cats...',
            'image'  => null,
            'url'   => 'http://lizclimo.tumblr.com/post/132165201759/bonus-comic-for-national-cat-day',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271425,
            'public'   => null,
        ],
        [
            'name' => 'UserFriendly - Web Designer',
            'image'  => null,
            'url'   => 'http://ars.userfriendly.org/cartoons/?id=19971206',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267119,
            'public'   => null,
        ],
        [
            'name' => 'PHP Sadness',
            'image'  => null,
            'url'   => 'http://phpsadness.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269615,
            'public'   => null,
        ],
        [
            'name' => 'GitHub - originell-django-kittenstorage Django Storage Engine which returns images of kittens if files could not be found.',
            'image'  => null,
            'url'   => 'https://github.com/originell/django-kittenstorage',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267009,
            'public'   => null,
        ],
        [
            'name' => 'XKCD Plots in Matplotlib Going the Whole Way',
            'image'  => null,
            'url'   => 'http://jakevdp.github.io/blog/2013/07/10/XKCD-plots-in-matplotlib/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271475,
            'public'   => null,
        ],
        [
            'name' => 'A better git log (Example)  Coderwall',
            'image'  => null,
            'url'   => 'https://coderwall.com/p/euwpig/a-better-git-log',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267453,
            'public'   => null,
        ],
        [
            'name' => 'Dealing with line endings - User Documentation',
            'image'  => null,
            'url'   => 'https://help.github.com/articles/dealing-with-line-endings/#platform-all',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269537,
            'public'   => null,
        ],
        [
            'name' => 'Hg Init a Mercurial tutorial by Joel Spolsky',
            'image'  => null,
            'url'   => 'http://hginit.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271584,
            'public'   => null,
        ],
        [
            'name' => 'Authentication Cheat Sheet - OWASP',
            'image'  => null,
            'url'   => 'https://www.owasp.org/index.php/Authentication_Cheat_Sheet',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271589,
            'public'   => null,
        ],
        [
            'name' => 'CSS 3D Clouds',
            'image'  => null,
            'url'   => 'https://www.clicktorelease.com/code/css3dclouds/#',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466270244,
            'public'   => null,
        ],
        [
            'name' => 'Excuses For Lazy Coders',
            'image'  => null,
            'url'   => 'http://developerexcuses.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267083,
            'public'   => null,
        ],
        [
            'name' => 'Fifty Shades of Grey text generator  Parody erotic fiction generated algorithmically.',
            'image'  => null,
            'url'   => 'http://www.xwray.com/fiftyshades',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466266989,
            'public'   => null,
        ],
        [
            'name' => 'Heroic Programming',
            'image'  => null,
            'url'   => 'http://c2.com/cgi/wiki?HeroicProgramming',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466266984,
            'public'   => null,
        ],
        [
            'name' => 'http--www.brendangregg.com-Specials-mkzombie.c',
            'image'  => null,
            'url'   => 'http://www.brendangregg.com/Specials/mkzombie.c',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267047,
            'public'   => null,
        ],
        [
            'name' => 'IE Add-on site',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?LinkId=50893',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'IE site on Microsoft.com',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?linkid=44661',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Microsoft At Home',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?linkid=55424',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Microsoft At Work',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?linkid=68920',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Microsoft Store',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?linkid=140813',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Album Covers Recreated with MS Paint',
            'image'  => null,
            'url'   => 'http://www.publiccollectors.org/MSPaintAlbumCovers.htm',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466267067,
            'public'   => null,
        ],
        [
            'name' => 'TEDxZurich - Jojo Mayer - Exploring the distance between 0 and 1 - YouTube',
            'image'  => null,
            'url'   => 'https://www.youtube.com/watch?v=KExLCJAuTXA',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269520,
            'public'   => null,
        ],
        [
            'name' => 'Get Windows Live',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?LinkId=69172',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Windows Live Gallery',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?LinkId=70742',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Windows Live Mail',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?LinkId=68925',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Windows Live Spaces',
            'image'  => null,
            'url'   => 'http://go.microsoft.com/fwlink/?LinkId=68927',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1363037966,
            'public'   => null,
        ],
        [
            'name' => 'Learn to write Gallifreyan in 9 simple steps',
            'image'  => null,
            'url'   => 'http://io9.gizmodo.com/learn-to-write-gallifreyan-in-9-simple-steps-506989915',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466269580,
            'public'   => null,
        ],
        [
            'name' => 'Let me google that for you',
            'image'  => null,
            'url'   => 'http://lmgtfy.com/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1466271385,
            'public'   => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse flat IE bookmarks (no directories).
     */
    public function testParseFlat(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/internet_explorer_11_flat.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse nested IE bookmarks (directories and subdirectories).
     */
    public function testParseNested(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/internet_explorer_11_nested.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_2, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $context = [
            NetscapeBookmarkDecoder::KEEP_NESTED_TAGS => false,
        ];

        $this->decoder = new NetscapeBookmarkDecoder($context);
    }

    protected function tearDown(): void
    {
        $this->decoder = null;
    }
}
