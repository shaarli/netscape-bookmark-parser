<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;

/**
 * Ensure that trying to import an empty file is handled properly.
 */
class ParseEmptyFileTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse empty file.
     */
    public function testParseEmptyFile(): void
    {
        $content = file_get_contents(self::FIXTURE_DIRECTORY . 'input/empty.htm');

        $result = $this->decoder->decode($content);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
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
