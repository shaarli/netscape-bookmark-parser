<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;

class NetscapeBookmarkDecoderTest extends TestCase
{
    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse boolean attribute values evaluating to true.
     *
     * Standard booleans:  '1|on|one|t|true|y|yes'
     * HTML forms:         'checked|ok|okay'
     * other:              '\+'
     * integers != [0, 1] => true: These are removed
     */
    public function testParseBooleanAttributesAsTrue(): void
    {
        foreach (
            [
                '+',
                '1',
                'array',
                'checked',
                'ok',
                'okay',
                'on',
                'one',
                't',
                'true',
                'y',
                'yes',
            ] as $value
        ) {
            $this->assertTrue($this->decoder->parseBoolean($value));
        }
    }

    /**
     * Parse boolean attribute values evaluating to false.
     *
     * Standard booleans: '0|f|false|n|neg|nil|no|off|zero'
     * Empty values:      'empty|null|void'
     * Errors:            'die|exit'
     * Other:             '\-'
     */
    public function testParseBooleanAttributesAsFalse(): void
    {
        foreach (
            [
                '-',
                '0',
                'die',
                'empty',
                'exit',
                'f',
                'false',
                'n',
                'neg',
                'nil',
                'no',
                'null',
                'off',
                'void',
                'zero',
            ] as $value
        ) {
            $this->assertFalse($this->decoder->parseBoolean($value));
        }
    }

    /**
     * Parse boolean attribute values, fail and return false.
     */
    public function testParseInvalidBooleanAttributes(): void
    {
        foreach (
            [
                '+++',
                '--',
                'nope',
                'yess',
                'yup',
            ] as $value
        ) {
            $this->assertFalse($this->decoder->parseBoolean($value));
        }
    }

    /**
     * Parse log dates.
     */
    public function testParseLogDates(): void
    {
        $this->assertEquals(
            '971211336',
            $this->decoder->parseDate(
                '10/Oct/2000:13:55:36 -0700',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
        $this->assertEquals(
            '971186136',
            $this->decoder->parseDate(
                '10/Oct/2000:13:55:36 +0000',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
        $this->assertEquals(
            '971175336',
            $this->decoder->parseDate(
                '10/Oct/2000:13:55:36 +0300',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
    }

    /**
     * Parse Unix timestamps.
     */
    public function testParseUnixDates(): void
    {
        $this->assertEquals(
            '1456433748',
            $this->decoder->parseDate(
                '1456433748',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
        $this->assertEquals(
            '971175336',
            $this->decoder->parseDate(
                '971175336',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
        $this->assertEquals(
            '-371211336',
            $this->decoder->parseDate(
                '-371211336',
                NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
                NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
            )
        );
    }

    /**
     * Parse invalid date.
     */
    public function testParseInvalidDates(): void
    {
        // Just to make sure that even if the CI is slow, we're fine.
        $range = [
            time() - 5,
            time() + 5,
        ];

        $date = $this->decoder->parseDate(
            '0',
            NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
            NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
        );
        $this->assertGreaterThanOrEqual($range[0], $date);
        $this->assertLessThan($range[1], $date);

        $date = $this->decoder->parseDate(
            'not a date',
            NetscapeBookmarkDecoder::DEFAULT_NORMALIZE_DATES,
            NetscapeBookmarkDecoder::DEFAULT_DATE_RANGE
        );
        $this->assertGreaterThanOrEqual($range[0], $date);
        $this->assertLessThan($range[1], $date);
    }

    /**
     * Sanitize tags derived from bookmark folder names.
     */
    public function testSanitizeFolderTagString(): void
    {
        $this->assertEquals([], $this->decoder->sanitizeTags(''));

        $this->assertEquals(
            ['hello'],
            $this->decoder->sanitizeTags('-hello')
        );
        $this->assertEquals(
            ['hello'],
            $this->decoder->sanitizeTags('_hello')
        );

        $this->assertEquals(
            [
                'hello',
                'world',
            ],
            $this->decoder->sanitizeTags('-hello$, WOrld')
        );
        $this->assertEquals(
            [
                'hello',
                'world',
            ],
            $this->decoder->sanitizeTags('-Hello$ - WOrlD!')
        );
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
