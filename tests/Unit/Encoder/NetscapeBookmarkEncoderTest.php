<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkEncoder;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class NetscapeBookmarkEncoderTest extends TestCase
{
    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED = "<!DOCTYPE NETSCAPE-Bookmark-file-1>\n<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\">\n<TITLE>Bookmarks</TITLE>\n<H1>Bookmarks</H1>\n<DL><p>\n<DT><H3 ADD_DATE=\"1612572000\" LAST_MODIFIED=\"1612572000\">TangoMan</H3>\n<DL><p>\n<DT><A HREF=\"https://tangoman.io\" PRIVATE=\"0\" ICON=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC9ElEQVQ4jWWTS2tdZRSGn/Xtvc+1J8k5ITk20iSlCDoopolYQQcOHAidKNhBJoLDDioiRPwDIt7AgQOlggOLiLYEFBEEJw6UYluEggpCkxCE5NRc9zn79l2WgyZQdI2f9bJgPa9wNKoqIqIAn9/Uk4nyZGZ5yFooPFtlzo03LsjWESwcsfLg8lc/a6/WYqVwLFeWOQtUDvISKsd64fhi/x7vffiK7IMKiMrxBat39IwJXIsbLBymUBZeSxe09BFZhdggorGQptzey3jp05dlDVQMwOaB9mLlelxnYXcP660Lz8wd8uLZQs71D6S0Sj7Kw8Fg3+aOxYOCry+8rV0AA/DZT6zEDR7PR1TWk1SVNd0TCVO9jjRjzygbUdnSpLmNNtbWKmCp2eV1EJXlK9ovHb/OT/Pw3ATMdEpZmsnp9xrSaNT5Z/eQnTSQ55l+9GPBxk4I7UZDamMzm7aKzsfW81RkOLU2QO9uIwv9gudOZyRxGwE6rZjxpmM4RBIqglNTpEOi5sRs0ugsxUHoxzGaOFWnwp87bd75IZNLz+4zOzPFjT/2uH6nTS3pMBjlGulQvSsJwYmB+fj4CwEhFrRwsVk/HMdrjqqShzp30wk0G1AdDkEd3lWoBkTQWJVt9fddCKIIUI88ggLgq5x06y8in2LwEpxFvUVEQNkwKL+o6qYRFCUgRgOxqgqK0G16Hu3tcWZK1ahTb/OQNMc0rnc2gnLTrF6SQQhyNUrE2Dz1kSBpaeTvnUyNKE8vzOrHl8/qmy9MS00Krarcj518zBiTXF29JIMYVErl/cjyfNLqLFbpwLY73ei730pRv67TvTb1WsTmvWEo86GfnHuiFjdO3LIjPgAVOXb64hU9TeCaalg81cloRiX5/lZoxY5Igvl9K2Bbj1Brjd0qKi5+e/m+ykddOAr5RMddYKXb1OX5SZ1rxTayzrGd4jfT9jrwZVbuvvv9q5OH/yvTgxU9/5b2ZyY5160zXwbYzdhIPLe/eU22/8v+C6nZr9mWJU7qAAAAAElFTkSuQmCC\">TangoMan.io</A>\n<DD>FullStack PHP Symfony / Javascript Vue.JS Web Developer with strong interest for Cybersecurity, DevOps and Agile methodology.\n<DT><A HREF=\"https://github.com/TangoMan75\"> ADD_DATE=\"1612572000\" LAST_MODIFIED=\"1612572000\">TangoMan75</A>\n<\DL><p>\n<\DL><p>\n";
    // phpcs:enable

    /**
     * @var NetscapeBookmarkEncoder|null
     */
    private $encoder;

    // --------------------------------------------------
    // Exceptions
    // --------------------------------------------------

    public function testEncodeStringShouldRaiseException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Argument 1 passed to %s::encode must be of type array, string given',
                NetscapeBookmarkEncoder::class
            )
        );

        $this->encoder->encode('foobar');
    }

    public function testEncodeIntegerShouldRaiseException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Argument 1 passed to %s::encode must be of type array, integer given',
                NetscapeBookmarkEncoder::class
            )
        );

        $this->encoder->encode(666);
    }

    // --------------------------------------------------
    // Business Logic
    // --------------------------------------------------

    public function testEncoderSupportsEncodingShouldReturnExpectedResult(): void
    {
        $result = $this->encoder->supportsEncoding('netscape');

        $this->assertTrue($result);
    }

    public function testEncoderShouldReturnExpectedResult(): void
    {
        // phpcs:disable Generic.Files.LineLength
        $data = [
            [
                'name'         => 'TangoMan',
                'dateCreated'  => '1612572000',
                'dateModified' => '1612572000',
                'bookmarks'    => [
                    [
                        'name'        => 'TangoMan.io',
                        'url'         => 'https://tangoman.io',
                        'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC9ElEQVQ4jWWTS2tdZRSGn/Xtvc+1J8k5ITk20iSlCDoopolYQQcOHAidKNhBJoLDDioiRPwDIt7AgQOlggOLiLYEFBEEJw6UYluEggpCkxCE5NRc9zn79l2WgyZQdI2f9bJgPa9wNKoqIqIAn9/Uk4nyZGZ5yFooPFtlzo03LsjWESwcsfLg8lc/a6/WYqVwLFeWOQtUDvISKsd64fhi/x7vffiK7IMKiMrxBat39IwJXIsbLBymUBZeSxe09BFZhdggorGQptzey3jp05dlDVQMwOaB9mLlelxnYXcP660Lz8wd8uLZQs71D6S0Sj7Kw8Fg3+aOxYOCry+8rV0AA/DZT6zEDR7PR1TWk1SVNd0TCVO9jjRjzygbUdnSpLmNNtbWKmCp2eV1EJXlK9ovHb/OT/Pw3ATMdEpZmsnp9xrSaNT5Z/eQnTSQ55l+9GPBxk4I7UZDamMzm7aKzsfW81RkOLU2QO9uIwv9gudOZyRxGwE6rZjxpmM4RBIqglNTpEOi5sRs0ugsxUHoxzGaOFWnwp87bd75IZNLz+4zOzPFjT/2uH6nTS3pMBjlGulQvSsJwYmB+fj4CwEhFrRwsVk/HMdrjqqShzp30wk0G1AdDkEd3lWoBkTQWJVt9fddCKIIUI88ggLgq5x06y8in2LwEpxFvUVEQNkwKL+o6qYRFCUgRgOxqgqK0G16Hu3tcWZK1ahTb/OQNMc0rnc2gnLTrF6SQQhyNUrE2Dz1kSBpaeTvnUyNKE8vzOrHl8/qmy9MS00Krarcj518zBiTXF29JIMYVErl/cjyfNLqLFbpwLY73ei730pRv67TvTb1WsTmvWEo86GfnHuiFjdO3LIjPgAVOXb64hU9TeCaalg81cloRiX5/lZoxY5Igvl9K2Bbj1Brjd0qKi5+e/m+ykddOAr5RMddYKXb1OX5SZ1rxTayzrGd4jfT9jrwZVbuvvv9q5OH/yvTgxU9/5b2ZyY5160zXwbYzdhIPLe/eU22/8v+C6nZr9mWJU7qAAAAAElFTkSuQmCC',
                        'description' => 'FullStack PHP Symfony / Javascript Vue.JS Web Developer with strong interest for Cybersecurity, DevOps and Agile methodology.',
                        'public'      => true,
                    ],
                    [
                        'name'         => 'TangoMan75',
                        'url'          => 'https://github.com/TangoMan75',
                        'public'       => false,
                        'dateCreated'  => '1612572000',
                        'dateModified' => '1612572000',
                    ],
                ],
            ],
        ];
        // phpcs:enable

        $result = $this->encoder->encode($data);

        $this->assertSame(self::EXPECTED, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->encoder = new NetscapeBookmarkEncoder();
    }

    protected function tearDown(): void
    {
        $this->encoder = null;
    }
}
