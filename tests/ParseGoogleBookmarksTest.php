<?php

namespace Shaarli\NetscapeBookmarkParser;

/**
 * Ensure Google Bookmarks exports are properly parsed
 *
 * The reference data has been dumped with Google Bookmarks on 2018-10-01
 */
class ParseGoogleBookmarksTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Delete log file.
     */
    protected function tearDown(): void
    {
        @unlink(LoggerTestsUtils::getLogFile());
    }

    /**
     * Parse nested Google Bookmarks (directories and subdirectories)
     */
    public function testParseNested()
    {
        $parser = new NetscapeBookmarkParser(true, null, '1');
        $bkm = $parser->parseFile('tests/input/google_bookmarks_nested.htm');
        $this->assertEquals(6, sizeof($bkm));

        $this->assertEquals('', $bkm[0]['note']);
        $this->assertEquals('1', $bkm[0]['pub']);
        $this->assertEquals('unlabeled', $bkm[0]['tags']);
        $this->assertEquals('1515515697', $bkm[0]['time']);
        $this->assertEquals(
            'WordHippo | Comprehensive Thesaurus for Synonyms and Antonyms',
            $bkm[0]['title']
        );
        $this->assertEquals('https://www.wordhippo.com/', $bkm[0]['uri']);

        $this->assertequals('', $bkm[1]['note']);
        $this->assertequals('1', $bkm[1]['pub']);
        $this->assertequals('unlabeled', $bkm[1]['tags']);
        $this->assertequals('1519067075', $bkm[1]['time']);
        $this->assertequals(
            'powershell - Move files into alphabetically named folders - Stack Overflow',
            $bkm[1]['title']
        );
        $this->assertequals(
            'https://stackoverflow.com/questions/20180072/'
            .'move-files-into-alphabetically-named-folders',
            $bkm[1]['uri']
        );

        $this->assertequals('', $bkm[2]['note']);
        $this->assertequals('1', $bkm[2]['pub']);
        $this->assertequals('unlabeled', $bkm[2]['tags']);
        $this->assertequals('1523996185', $bkm[2]['time']);
        $this->assertequals('Free Lien Search', $bkm[2]['title']);
        $this->assertequals('http://www.searchq.com/', $bkm[2]['uri']);

        $this->assertequals('', $bkm[3]['note']);
        $this->assertequals('1', $bkm[3]['pub']);
        $this->assertequals('unlabeled', $bkm[3]['tags']);
        $this->assertequals('1529505663', $bkm[3]['time']);
        $this->assertequals('OpenNIC Project', $bkm[3]['title']);
        $this->assertequals('https://www.opennic.org/', $bkm[3]['uri']);

        $this->assertequals('', $bkm[4]['note']);
        $this->assertequals('1', $bkm[4]['pub']);
        $this->assertequals('unlabeled', $bkm[4]['tags']);
        $this->assertequals('1532442262', $bkm[4]['time']);
        $this->assertequals('Kubo and the Two Strings (2016) - IMDb', $bkm[4]['title']);
        $this->assertequals('https://www.imdb.com/title/tt4302938/', $bkm[4]['uri']);

        $this->assertequals('', $bkm[5]['note']);
        $this->assertequals('1', $bkm[5]['pub']);
        $this->assertequals('unlabeled', $bkm[5]['tags']);
        $this->assertequals('1523996194', $bkm[5]['time']);
        $this->assertequals('Home | NextAce', $bkm[5]['title']);
        $this->assertequals('https://nextace.com/', $bkm[5]['uri']);
    }
}
