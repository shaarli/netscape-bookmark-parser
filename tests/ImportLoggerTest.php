<?php

namespace Shaarli\NetscapeBookmarkParser;

use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;

/**
 * Class ImportLoggerTest
 *
 * Make sure that the log file is correctly generated.
 */
class ImportLoggerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var NetscapeBookmarkParser instance
     */
    protected $parser = null;

    /**
     * Initialize test resources
     */
    protected function setUp(): void
    {
        $this->parser = new NetscapeBookmarkParser();
    }

    /**
     * Delete log file.
     */
    protected function tearDown(): void
    {
        @unlink(LoggerTestsUtils::getLogFile());
        @unlink(LoggerTestsUtils::getLogFile('tmp'));
        @rmdir('tmp');
    }

    /**
     * Make sure that the log is created an contains INFO logs, without DEBUG logs.
     */
    public function testLoggerInfo()
    {
        $this->parser->parseFile('tests/input/shaarli.htm');
        $this->assertFileExists(LoggerTestsUtils::getLogFile());
        $content = file_get_contents(LoggerTestsUtils::getLogFile());
        $this->assertContains('[info]', $content);
        $this->assertNotContains('[debug]', $content);
    }

    /**
     * Make sure that the log is created an contains INFO and DEBUG logs.
     */
    public function testLoggerDebug()
    {
        $this->parser = new NetscapeBookmarkParser(true, array(), '0');
        $this->parser->setLogger(new Logger(
            'logs',
            LogLevel::DEBUG,
            array(
                'prefix' => 'import.',
                'extension' => 'log',
            )
        ));
        $this->parser->parseFile('tests/input/shaarli.htm');
        $this->assertFileExists(LoggerTestsUtils::getLogFile());
        $content = file_get_contents(LoggerTestsUtils::getLogFile());
        $this->assertContains('[info]', $content);
        $this->assertContains('[debug]', $content);
    }

    /**
     * Test custom directory for logs.
     */
    public function testLoggerAlternativeDir()
    {
        mkdir('tmp');
        $this->parser = new NetscapeBookmarkParser(true, array(), '0');
        $this->parser->setLogger(new Logger(
            'tmp',
            LogLevel::INFO,
            array(
                'prefix' => 'import.',
                'extension' => 'log',
            )
        ));
        $this->parser->parseFile('tests/input/shaarli.htm');
        $this->assertFileExists(LoggerTestsUtils::getLogFile('tmp'));
    }
}
