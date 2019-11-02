<?php

namespace Shaarli\NetscapeBookmarkParser;

/**
 * Ensure Safari exports are properly parsed
 */
class ParseSafariBookmarksTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Delete log file.
     */
    protected function tearDown(): void
    {
        @unlink(LoggerTestsUtils::getLogFile());
    }

    /**
     * Parse bookmarks as exported by Safari - Strip punctuation from folder names
     */
    public function testParseFoldedStripPunctuation()
    {
        $parser = new NetscapeBookmarkParser();
        $bkm = $parser->parseFile('tests/input/safari_folded.htm');
        $this->assertEquals(3, sizeof($bkm));

        $this->assertEquals('', $bkm[0]['note']);
        $this->assertEquals('0', $bkm[0]['pub']);
        $this->assertEquals('favoris', $bkm[0]['tags']);
        $this->assertEquals('GitHub', $bkm[0]['title']);
        $this->assertEquals('https://github.com/', $bkm[0]['uri']);

        $this->assertEquals('', $bkm[1]['note']);
        $this->assertEquals('0', $bkm[1]['pub']);
        $this->assertEquals('github shaarli', $bkm[1]['tags']);
        $this->assertEquals(
            'GitHub - shaarli/Shaarli:'
           .' The personal, minimalist, super-fast, database free,'
           .' bookmarking service - community repo',
            $bkm[1]['title']
        );
        $this->assertEquals('https://github.com/shaarli/Shaarli', $bkm[1]['uri']);

        $this->assertEquals('', $bkm[2]['note']);
        $this->assertEquals('0', $bkm[2]['pub']);
        $this->assertEquals('autre divers doc', $bkm[2]['tags']);
        $this->assertEquals(
            'Wikipedia, the free encyclopedia',
            $bkm[2]['title']
        );
        $this->assertEquals(
            'https://en.wikipedia.org/wiki/Main_Page',
            $bkm[2]['uri']
        );
    }
}
