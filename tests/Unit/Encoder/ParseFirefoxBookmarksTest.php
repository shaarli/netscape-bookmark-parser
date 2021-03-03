<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

/**
 * Ensure Firefox exports are properly parsed.
 *
 * The reference data has been dumped with Mozilla Firefox 46.0.1
 */
class ParseFirefoxBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#ignoring-parts-of-a-file
    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name' => 'Recently saved',
            'image'  => null,
            'url'   => 'place:folder=BOOKMARKS_MENU&folder=UNFILED_BOOKMARKS&folder=TOOLBAR&queryType=1&sort=12&maxResults=10&excludeQueries=1',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'Recent tags',
            'image'  => null,
            'url'   => 'place:type=6&sort=14&maxResults=10',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'kafene/netscape-bookmark-parser: a php script (function) to parse netscape format bookmark files',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABrElEQVQ4jY2Sv2pUURDGv7vZ4p77J2dmvnO42ihaK1gEXSKEPIDgC/gC9mJvYW1noliF9OIjbGGeISsSSGUhkRhw12Dg2Oxd7l5114Fpzpnv45sfA/SqqqodVd0jOaHZBc0uSE5Uda+qqp3+fLc2KHLQxJhWNUUOAGz8ITazo3Xits3saMmEIodNjMlExs65+wBe1HX9mWbHNDsO5AzAMwAPTGQ8T3IIAHDOjVpnVd1vUQAoumgAZACgqvvtvHNuhO7eRVFsrYI0h7y7xCOYnTQxJppd5nl+a51Bnuc3A/mziTEFsxMEctbEmEierhMvmJGnTYwpkDMEcjo3OAcw+A/9gGbf5wZTkJy0O4nI43Xquq4fLRiQnxDN3sUQEoAr2dz8VTv38J9i57YD+aVzD29RluU9X/sE4BLA2WAwSFmWTZ1zo1Y4HA53syz72j8oVb0LAAghvGliTBVwpyzLJ76ux977261BURRbItK/xldL8UxkTLNvqnoDgPTTB/LHYnfV93/dkeRrml3R7AzA9c7XtUVs71+upKzePzezjwCsffPeK0U+qOrT/vxvewCKQLKaviEAAAAASUVORK5CYII=',
            'url'   => 'https://github.com/kafene/netscape-bookmark-parser',
            'tags'  => [
                'github',
                'php',
                'netscape',
                'parser',
            ],
            'description'  => 'netscape-bookmark-parser - a php script (function) to parse netscape format bookmark files',
            'dateCreated'  => 1463686279,
            'public'   => null,
        ],
        [
            'name' => 'Programming in Lua',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAa0lEQVQ4jc1SQQ7AIAzi6TytP2MHs7h1zNqdRtLEqCDUAk1EhAAKoMa6Depe+Zj5AjX2CgFHdEI2wopMUifI7ObV1qyMR+7KuhNILurc1wim+3XzfP1GYOf/14P1ycXG+DZe742yJVdCK+IBt3VGOPv7/dsAAAAASUVORK5CYII=',
            'url'   => 'http://www.lua.org/pil/',
            'tags'  => [
                'lua',
                'script',
                'cpp',
                'dev',
            ],
            'description'  => null,
            'dateCreated'  => 1463686379,
            'public'   => null,
        ],
        [
            'name' => 'Survive The Deep End: PHP Security — Survive The Deep End: PHP Security :: v1.0a1',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAAcElEQVRIiWN0C4xgoCVgoqnp9LCABc5yCwjHo27XhpUQxpxpk4kxNyUrF8IYTkEEB/DQYMAdbvAQgANcQTf0g2gg4gB/eoUAIhMrwzANotFkSmcLRpMpQYAliIgBo8mUioDMOBhJyXToW8A42vglBAAK9B5UoZWPRQAAAABJRU5ErkJggg==',
            'url'   => 'http://phpsecurity.readthedocs.io/en/latest/index.html',
            'tags'  => [
                'php',
                'security',
                'best-practices',
                'dev',
                'web',
            ],
            'description'  => null,
            'dateCreated'  => 1463686400,
            'public'   => null,
        ],
        [
            'name' => 'True story: one code review too many | CommitStrip',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABB0lEQVQ4jd2SoW7DMBRF/UP5AqPAENNK4VE/IKaWUhRUpTSRQgJCWlYFjERjISUFBi59kpHJBkbvkK146chGpll6ki0/n3vvk1mSSvym2D8DNN2EpptQVsOmMctrZHn9HMCFgjYEbQhlNUAbQtNNoUkbwnqtBZhXJuvAhYIH+n0hW2hD4VxWAw7HSwzoxzlS/GodAJbbA/04Y7c/bSOQdShk++2gymoAWRci9OMcA7ShDYALhSyvg3Xvph9nAAhOWJJKnK9LFKGQLd7eP9B0E15e75EiFwpkXZgDS1KJ3f4Esg7n6wJtKDxew7QhLLdHuI8ceHuH4+XpLLhQKGQbah3rj33ln9QnfAc0XBIXmlYAAAAASUVORK5CYII=',
            'url'   => 'http://www.commitstrip.com/en/2016/02/10/true-story-one-code-review-too-many/',
            'tags'  => [
                'webcomic',
                'commit',
                'code',
                'review',
                'dev',
            ],
            'description'  => 'The blog relating the daily life of web agency developers',
            'dateCreated'  => 1463686493,
            'public'   => null,
        ],
        [
            'name' => 'How to run a meetup without giving up your life',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB2ElEQVQ4jaWTzWtTQRTFn6DV+hHTpC9+FFz3DxBEEURsmpjmvbyWVlcKRV10IVRqRQShUpCiIEglK92UCqIi0o0Kou2iC10UxZ3gXyCCIijv3pn3czFJeJWUCA5cmI97zj135oyntV7+J7xOCRLm2847EkiYR2q9aFTYELwhgUv20TCPlLqRoAeN/H9T0EySahYZ2YdeLmLuXkRG+5CmshSR1xZc85FKBlOfwq48xcxPEh/2kFK3U5bK9daBI99VOb4JvVLGvn6IefsYu/wEszCLTpeQSgYJcq5omHcELXA1i5zciXlwHbu6hH25SPL9K8mPb5hn85h7l9Bb55Agl1LQuDCp7EKqPdjVJRIg+fWTRGLM4k2n6phHfNRDrw6h02XiQdeOUxDkkNH92PevHDj+TWIMOjdOfMRDyjvQkb2uyJl+dGYMGdyGRgU8jQrEA13ozBgACW6YhVnk/EHsl0+Y+hRS3Op6v30BmTjkSFsKqlnk1AHsm0fYD8skn9cwz+uY+9ewH1ew715g7kygc+PojdPI2X5kaHf6DhptFLuccSoZdHgPMrAFObEZKW93LQS5VmVNP2PLGMOF9dZtriMfCRtP13CkpI0ktfZe/3tP2px1/I2d4g+H84qrnd//IAAAAABJRU5ErkJggg==',
            'url'   => 'http://whistlestudios.com/2016/03/how-to-run-a-meetup-without-giving-up-your-life/',
            'tags'  => [
                'meetup',
                'presentation',
                'event',
                'community',
            ],
            'description'  => 'If running a Meetup feels like a full-time job, you&#39;re probably doing it wrong. Volunteering is important and you can make it work with some smart maneuvering.',
            'dateCreated'  => 1463686521,
            'public'   => null,
        ],
        [
            'name' => 'The Most Important Object In Computer Graphics History Is This Teapot - Facts So Romantic - Nautilus',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAoUlEQVQ4jaXTsQ2DMBAF0KspLCagyE6swApZISMwQwawhF3ABGlo0tDQpIno0lD8T4GI5FDEPp90heWvJ/nkE/QV4Yyu+4qCriCs6LorKHBGDzgTAnx7HoWxCcL8TPvF3MYBXBfClxnATzgNOMIk8agVwNySr/sXgy/TAQwXcl3283RTAFaIseGpkoA/g40CgqeoACvE8xoH6L5y9jJlrvMGy2MMt2SxDwkAAAAASUVORK5CYII=',
            'url'   => 'http://nautil.us/blog/the-most-important-object-in-computer-graphics-history-is-this-teapot',
            'tags'  => [
                'teapot',
                '418',
                'computer',
                'graphics',
                'image',
                'sythesis',
            ],
            'description'  => 'Let’s play a game. I’ll show you a picture and a couple videos—just watch the first five seconds or so—and you figure out&amp;#8230;',
            'dateCreated'  => 1463686613,
            'public'   => null,
        ],
        [
            'name' => 'samhocevar/wincompose: Compose Key for Windows',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABrElEQVQ4jY2Sv2pUURDGv7vZ4p77J2dmvnO42ihaK1gEXSKEPIDgC/gC9mJvYW1noliF9OIjbGGeISsSSGUhkRhw12Dg2Oxd7l5114Fpzpnv45sfA/SqqqodVd0jOaHZBc0uSE5Uda+qqp3+fLc2KHLQxJhWNUUOAGz8ITazo3Xits3saMmEIodNjMlExs65+wBe1HX9mWbHNDsO5AzAMwAPTGQ8T3IIAHDOjVpnVd1vUQAoumgAZACgqvvtvHNuhO7eRVFsrYI0h7y7xCOYnTQxJppd5nl+a51Bnuc3A/mziTEFsxMEctbEmEierhMvmJGnTYwpkDMEcjo3OAcw+A/9gGbf5wZTkJy0O4nI43Xquq4fLRiQnxDN3sUQEoAr2dz8VTv38J9i57YD+aVzD29RluU9X/sE4BLA2WAwSFmWTZ1zo1Y4HA53syz72j8oVb0LAAghvGliTBVwpyzLJ76ux977261BURRbItK/xldL8UxkTLNvqnoDgPTTB/LHYnfV93/dkeRrml3R7AzA9c7XtUVs71+upKzePzezjwCsffPeK0U+qOrT/vxvewCKQLKaviEAAAAASUVORK5CYII=',
            'url'   => 'https://github.com/samhocevar/wincompose',
            'tags'  => [
                'github',
                'windows',
                'compose',
                'character',
                'keyboard',
                'input',
            ],
            'description'  => 'wincompose - Compose Key for Windows',
            'dateCreated'  => 1463686711,
            'public'   => null,
        ],
        [
            'name' => 'Hg Init: a Mercurial tutorial by Joel Spolsky',
            'image'  => null,
            'url'   => 'http://hginit.com/',
            'tags'  => [
                'hg',
                'mercurial',
                'version',
                'control',
                'scm',
                'python',
                'tutorial',
            ],
            'description'  => 'A friendly introduction to the Mercurial DVCS by Joel Spolsky',
            'dateCreated'  => 1463686747,
            'public'   => null,
        ],
        [
            'name' => 'Announcing Pony Mode – a Django editing mode for Emacs « Deadpan Sincerity',
            'image'  => null,
            'url'   => 'http://blog.deadpansincerity.com/2011/05/announcing-pony-mode-a-django-editing-mode-for-emacs/',
            'tags'  => [
                'emacs',
                'editor',
                'django',
                'pony',
                'python',
                'mode',
            ],
            'description'  => null,
            'dateCreated'  => 1463686825,
            'public'   => null,
        ],
        [
            'name' => 'Sysadmin Purity Test',
            'image'  => null,
            'url'   => 'http://www.bofh.net/sl_Purity.html',
            'tags'  => [
                'sysadmin',
                'test',
                'unix',
                'linux',
                'network',
                'security',
            ],
            'description'  => null,
            'dateCreated'  => 1463686863,
            'public'   => null,
        ],
        [
            'name' => 'Timeline of the Elves in Tolkien’s works | LotrProject Blog',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAf0lEQVQ4jaWS0Q3DIAxE3zkdPLN0go7AYsn1I01CK6RisPQk/MFxhw1gwJJ8npMMXbqZeLnPQegTsaIpcFZLZK/YCFuL4ZETuPvwTviVdXBNK47+cDHowFr8zEa4CVsYJSOsyCuqP280wp8xllK+SAv8FuBtdhMb29cv0MGcwBsCIGEx+vxyqwAAAABJRU5ErkJggg==',
            'url'   => 'http://lotrproject.com/blog/2013/02/08/timeline-of-the-elves-in-tolkiens-works/',
            'tags'  => [
                'tolkien',
                'lord',
                'rings',
                'elves',
                'timeline',
                'graphics',
                'genealogy',
                'fantasy',
            ],
            'description'  => null,
            'dateCreated'  => 1463686918,
            'public'   => null,
        ],
        [
            'name' => 'xkcd: Slippery Slope',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB5ElEQVQ4jYWTvYryQBSGT+UlbGdnQG1MGW8ggrcgiJ3lWIgTVBLRRlGSXhTRO9DeqxBMYSU2gpXYiM3zFZJxw+7yDQzze555550zYts2Wmt83ycMQ6IoIgxDfN9HKfVn1Vpj2zbieR4A8/kcETF1Pp/zv+J5HqK15na7ISKUSiWiKKJUKiEinE4nAGq1mgHXajUDaLVayGAwQGtNouQ7vdPpMJvNUspEhH6/nwYopYjjOAWI4xilFFEUISLMZjMTpJT6ALTWXC4XMpkMx+MRgOPxSCaT4XK50Ol0mE6nKXij0fgAWq0WAMPhMCVzOBwC0G638X3fBCulaLfbPwEAm80GEWGz2Zg513V/eOC67u8KLMtCRLAsyyhYLBZUq1UTXK1WWSwWaQ/u9zsiApBqr9crr9fLnJqoeTweH8B4PObr64vJZJICTCYTcrkcIsLz+SQMQ8Iw5Pl8IiKcz2e01u9nbDabJni5XBpIvV43yZRcAeBwOLDf79+ZmHjQ6/XIZrMAFAoFut2uMXK1WlEulymXy6zXazOfMrFYLNLr9QDodrsUi0WzsVKpsN1u2e12OI6TBiQpnMhLyvfxX33P8xDHcd7fUoQgCFBKEQQBIoJt22ZtNBoxGo0QEfL5PEEQYNs2/wB6OZwvN52TQwAAAABJRU5ErkJggg==',
            'url'   => 'http://xkcd.com/1332/',
            'tags'  => [
                'xkcd',
                'webcomic',
                'slope',
                'respect',
            ],
            'description'  => null,
            'dateCreated'  => 1463687035,
            'public'   => null,
        ],
        [
            'name' => 'minecraft - Is it dangerous to go extreme pig riding in a thunderstorm? - Arqade',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAkElEQVQ4jeWSPQ6AMAiFO7WTt2DxBt3awat4OVeO5W7SCRdJgFJjYpx8SRegXx4/IXypCKVFKO1PgCNnsp8tRNZ0muZFAeiSBLiOmGoL7wDKCQetbQmw7SgnMoiIhIiUoPJ/SlCJ40MAvyeAbjsRSlu3XSUtQOa41gV4s7C9uwBv3xwb3Uc3RG+9o8N5deJSJwZNzji30evlAAAAAElFTkSuQmCC',
            'url'   => 'http://gaming.stackexchange.com/questions/21261/is-it-dangerous-to-go-extreme-pig-riding-in-a-thunderstorm',
            'tags'  => [
                'minecraft',
                'game',
                'indie',
                'pig',
                'wtf',
            ],
            'description'  => null,
            'dateCreated'  => 1463687183,
            'public'   => null,
        ],
        [
            'name' => 'How To Ask Questions The Smart Way',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACOklEQVQ4jY2SzUtUYRjFz0wItmgXbqR/wUVEtGklbty4SRchLmwZ1KKoHKZRDFJmIUrD2CLdTOhY4KLBHGa6ca/zpXdm7pV7h9AWIhEEQetAvf1aTDNmGvXAWbzv88F5znmkM8Iw8hhGnn/9nRmtolptDstaxbJWMc0MjhPn9/yZUSisIEnlcopqNUGtNsfu7m1qtTlsO4llrWIYeUwzc5JN61Gvz9BojFGvz+C603jeODs7d/G8GLadxHHiVCoLNBpjp9mY5hssa5V6fQbPi+E4cQqFFTKZLMXiMtXqLK47hedNtNf6rTmDaWZw3WkcJ45tJ5GkpaVNurq+k0ptIUm2nWR7+ymuO31ShxatajWBbSfJ5QwkaWDgE1JAf/9nJCmXM3CcONVqAs8bZ2vrOSeGeN4EpdIikjQ/v4kU0BE6QApIPGuyKJUW8bwJyuXUsZCGkf+1+/GAK5e/IgVt9PR8Q5KKxWV8P3q8RjZrUS6ncJw4rjuF7y/yOPYBKeBqaIshpekL55ACHj7axfcX8f37+H6USmWBtv8bG6+RpLdrFhe7D7mnaaKhSa6pTDQ0STT0hAvdkF17T2vl9oAWE0m6NfoRKSAefsALjTKrO7zSDW6Gl5ACmnlpfb10+iLT6SLnOw/b4vWFcwwpzXVZXFLTkc7OI16m/mjO598hSU27mkUdoQN07scJdHQcIQX09n5p29qm3hLufxGLeU0WraOJRBoMDu4zMrLH8PDfMTKyx+DgPpFIA0n6CaTTAubTaAiPAAAAAElFTkSuQmCC',
            'url'   => 'http://catb.org/~esr/faqs/smart-questions.html',
            'tags'  => [
                'question',
                'faq',
                'bug',
                'report',
                'dev',
                'support',
            ],
            'description'  => null,
            'dateCreated'  => 1463687293,
            'public'   => null,
        ],
        [
            'name' => 'Heroic Programming',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACn0lEQVQ4jWWTS0iUURTHP9rWQnBly6hFRb4QXLqQNhEhIYS6GiTMQTLpIYpvaUxFbRIXodaEOgvN8YHhqAgqNioKhZiJyiyahYMzOFrofH7fvffXYh5q3dW5h/O/55x7fkcjepRSAASDBuGwGfdF3VFbAQopJVJKADSlFFIqDMNEKbDbO+jqsqGUwjAMQHH+xBLFbC12MU0DAI9nmra2BgAMw0Cps+xSCgB2dr7j8+1GKtB1id8fjgoEx8e/6e7+gGkaCGFimgIhRFx8dBSkqektKyt+QiGJpuun5OY+ZGJiAoDd3RA2WyW6fvxP6RAI+GlsfMrk5Ges1uc4HONoUkq2t7+Rk3OX5eUpTBMqKqrY3w+wsDDH9PQgLpeTqqo3WCwPyMi4SknJI3Jz72G329GUEkipWF/fpKDAQl1dNVlZGTQ3v6S0tA6nc4DV1UW83j3W179itZawtrZEa2s1weAJWigEbvcv/H7F3p6kv/8jhYU5BAJ7ABwcwOjoIABOZx8WywuGhtw4HO8BiWYYCiEAZLzf9vbXCGEwO+umsvIVZWXPaGioY2fnB0lJV8jLy+L0NIyU8TGq6E8rtra2sNka8HjmqK8vx+f7SSgkSEm5RlHRY9LSrjM19QUAIQRabM5CRECamRmluNhCfX0HBwcBAA4PJZmZKaSl3WJsbD4qjsSfA0kAiqWlTWpqaqitfcLGRhCvV2dgoJf09JuMjHQjpRkVR7DWzihT6PoxHs8cnZ19tLR0Mj7uIj//PqmpNxgedscTxXCOoxxbjKOjP9TWWnG5hkhIuExy8h2yszNZXl6Mknp6QXxhmZSSOByfSEy8hMWST3LybcrLG9H1k3jPF7eSswciVQjm50fo7e2mp+cd4XA4HiQic/5PDPAXI19ss5HTgrUAAAAASUVORK5CYII=',
            'url'   => 'http://c2.com/cgi/wiki?HeroicProgramming',
            'tags'  => [
                'dev',
                'wikiwikiweb',
                'deadline',
                'rush',
            ],
            'description'  => null,
            'dateCreated'  => 1463687380,
            'public'   => null,
        ],
        [
            'name' => 'Chocolate Consumption, Cognitive Function, and Nobel Laureates - Chocolate consumption cognitive function and nobel laurates (NEJM).pdf',
            'image'  => null,
            'url'   => 'http://www.biostat.jhsph.edu/courses/bio621/misc/Chocolate%20consumption%20cognitive%20function%20and%20nobel%20laurates%20%28NEJM%29.pdf',
            'tags'  => [
                'chocolate',
                'research',
                'wtf',
                'statistics',
                'nobel',
            ],
            'description'  => null,
            'dateCreated'  => 1463687466,
            'public'   => null,
        ],
        [
            'name' => 'Welcome — Statistics Done Wrong',
            'image'  => null,
            'url'   => 'http://www.statisticsdonewrong.com/',
            'tags'  => [
                'statistics',
                'best-practices',
                'donot',
                'data',
                'analysis',
            ],
            'description'  => null,
            'dateCreated'  => 1463687501,
            'public'   => null,
        ],
        [
            'name' => 'Garkov -- Garfield + Markov chains -- Josh Millard',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAVklEQVQ4jb2PwQ0AIAgD2YlpO62+jIAEozWS9NOWU0REGilvjKmWQscbqlpCkmwGTwHWix0KYPMtIHv1PyCesgXYyQBJvpaOBMABAByJB9AnkMvzB7fqX6rPpXaHM3oAAAAASUVORK5CYII=',
            'url'   => 'http://joshmillard.com/garkov/',
            'tags'  => [
                'garfield',
                'markov',
                'language',
                'parody',
                'comic',
            ],
            'description'  => null,
            'dateCreated'  => 1463687585,
            'public'   => null,
        ],
        [
            'name' => 'Opt out of global data surveillance programs like PRISM, XKeyscore, and Tempora - PRISM Break - PRISM Break',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAAAAAA6mKC9AAAAVklEQVQY02NgIAU4saBwebeUMyPz/b5PRJFv+t+BzDU5+N8Pma95////FRVRGnABbu3Q1v//vzogK+L4f1QOmR/xfwGKHUkfs5G5TNGb9VHkuYJI8iEArKwXyBGzk/kAAAAASUVORK5CYII=',
            'url'   => 'https://prism-break.org/en/',
            'tags'  => [
                'prism',
                'break',
                'privacy',
                'self-hosted',
                'web',
                'service',
            ],
            'description'  => 'Opt out of global data surveillance programs like PRISM, XKeyscore and Tempora. Help make mass surveillance of entire populations uneconomical! We all have a right to privacy, which you can exercise today by encrypting your communications and ending your reliance on proprietary services.',
            'dateCreated'  => 1463687628,
            'public'   => null,
        ],
        [
            'name' => 'Fractal Flowchart - Spiked Math',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAA3NCSVQICAjb4U/gAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1MzmNZGAwAAALFJREFUOE+9krsNgDAMRGFj5mAESlo2QGIFJOhoItG5I11KuLPNR1SkwUphObnTO0NZNVORVRBknSLrNXH+E6zzbhVbSzXEs1/6bZ8Hj2pIfH2NDLINEKe+m6pOBG1Yba4Cjk5jXxpdUXCpx8Ruk/oWNH59I9EiCTRBoJQQL8f3lkAi48IAsGQMAwOz4inSMxN7CBgA0EavMG7kGdyJbrTXa92B631pmvvHD/f1F8xGOgADBfMg/DYL2AAAAABJRU5ErkJggg==',
            'url'   => 'http://spikedmath.com/570.html',
            'tags'  => [
                'math',
                'fractal',
                'flowchart',
                'chart',
            ],
            'description'  => 'Fractal Flowchart - Spiked Math Comic - A daily math webcomic meant to entertain and humor the geek in you...',
            'dateCreated'  => 1463687722,
            'public'   => null,
        ],
        [
            'name' => 'Most visited',
            'image'  => null,
            'url'   => 'place:sort=8&maxResults=10',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'Getting Started',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAz5JREFUeNpcU0toXFUY/s49596588ikySSmM8rk0UkJEirVTVEjYk1NUdRFFgouXZQI2k2hUCjdiYIuCi4Kuig0DbqQYgU3Yi0iFRuRCBMwaZvMZDTNY95z3/fM8b8jldpzOeeee/i/737n+/+f4ZExf730rkiaZ9NJMx/nmk5HypMqqLr+ZuD4F67N5ZYejmfRsnvhyKsLhSs3zP70SubgYKHSdFENu+gXAprQIGnvBi5ez0m1b6u7M399+PTx+UvtCKtFi2F6195qXK2byir88esy5ksfYND5DhuhRCtUKBNB0Q7w5Z8ee2GgWdjOn250fn5v5j8F5dOHlZD0kWRgAwp3hrKY0S9BJWKIcQ5PShhNG4+1bHx+IocT+RXcrRSDMfFNRvvt3Oyp/icIrRhUl9hoO4kt3F55Bxf3LkLV20jWOohbDjzXxyc/lMH0cRSyCd1xq+dFhu986t7T0CUwIzB8EkW3O5ibhj44ib7NJhiBKRoB/aS4ZWHjbxtjGQYP7nGRTjim1SaQqYiAVAREpHG8vzWJn+6PQ6CF0HPR7nQQczpYeEWHyWMUkwU8MSECGwgJxAWp9xWKNzkuH3oet+JDlIE9Momedh1G4CN0bfhVG9nsS0BQQthJx0V7j3elq7ihqV5ezQTwZmodP9ZGkU/bOPr4Nr53xtDYsaD7Dg4nNqFaH5OCYSSdGhf7daNmuv6wEKqXk/yExKGBHSznFsH6FFpKQ/JAA0ulUejWLt44lkHXsqDaX6C6Nl4Rnq8vK8s/KThDMlJhkI91YOO+iR3XwEelCdTCBLSgijNzd6DLNfhlHfZ6FtWiWBQpq/V2LdSrrNPljBQkoOjuCiPxAMutOIbkPqYSEqeequGZaTLzdhZhS0PlnlB9bvhtr5CuHj3y2Qj8hVQ/kEopxONEEsO/0yATDYXYAdWrE69JEElXq7Hyk0tro+xBU1yZmr4xrIcvptIRCZlJJAYBmRGRkD08aivA7VDvWPqt564Xn41w/AHB1/u7l1/uGxGU8mNcgodUNDIq0JDeLnpzc1uo1Qr76rWbqyf/142PjsXJqdkmN2YDnQ9oGkJNU+t57q7qUv4y9/t64+HYfwQYAN7OczrzUDvGAAAAAElFTkSuQmCC',
            'url'   => 'https://www.mozilla.org/en-US/firefox/central/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
    ];

    public const EXPECTED_2 = [
        [
            'name' => 'Recently saved',
            'image'  => null,
            'url'   => 'place:folder=BOOKMARKS_MENU&folder=UNFILED_BOOKMARKS&folder=TOOLBAR&queryType=1&sort=12&maxResults=10&excludeQueries=1',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'Recent tags',
            'image'  => null,
            'url'   => 'place:type=6&sort=14&maxResults=10',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'Timeline of the Elves in Tolkien’s works | LotrProject Blog',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAf0lEQVQ4jaWS0Q3DIAxE3zkdPLN0go7AYsn1I01CK6RisPQk/MFxhw1gwJJ8npMMXbqZeLnPQegTsaIpcFZLZK/YCFuL4ZETuPvwTviVdXBNK47+cDHowFr8zEa4CVsYJSOsyCuqP280wp8xllK+SAv8FuBtdhMb29cv0MGcwBsCIGEx+vxyqwAAAABJRU5ErkJggg==',
            'url'   => 'http://lotrproject.com/blog/2013/02/08/timeline-of-the-elves-in-tolkiens-works/',
            'tags'  => [
                'tolkien',
                'lord',
                'rings',
                'elves',
                'timeline',
                'graphics',
                'genealogy',
                'fantasy',
            ],
            'description'  => null,
            'dateCreated'  => 1463686918,
            'public'   => null,
        ],
        [
            'name' => 'True story: one code review too many | CommitStrip',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABB0lEQVQ4jd2SoW7DMBRF/UP5AqPAENNK4VE/IKaWUhRUpTSRQgJCWlYFjERjISUFBi59kpHJBkbvkK146chGpll6ki0/n3vvk1mSSvym2D8DNN2EpptQVsOmMctrZHn9HMCFgjYEbQhlNUAbQtNNoUkbwnqtBZhXJuvAhYIH+n0hW2hD4VxWAw7HSwzoxzlS/GodAJbbA/04Y7c/bSOQdShk++2gymoAWRci9OMcA7ShDYALhSyvg3Xvph9nAAhOWJJKnK9LFKGQLd7eP9B0E15e75EiFwpkXZgDS1KJ3f4Esg7n6wJtKDxew7QhLLdHuI8ceHuH4+XpLLhQKGQbah3rj33ln9QnfAc0XBIXmlYAAAAASUVORK5CYII=',
            'url'   => 'http://www.commitstrip.com/en/2016/02/10/true-story-one-code-review-too-many/',
            'tags'  => [
                'webcomic',
                'commit',
                'code',
                'review',
                'dev',
            ],
            'description'  => 'The blog relating the daily life of web agency developers',
            'dateCreated'  => 1463686493,
            'public'   => null,
        ],
        [
            'name' => 'xkcd: Slippery Slope',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB5ElEQVQ4jYWTvYryQBSGT+UlbGdnQG1MGW8ggrcgiJ3lWIgTVBLRRlGSXhTRO9DeqxBMYSU2gpXYiM3zFZJxw+7yDQzze555550zYts2Wmt83ycMQ6IoIgxDfN9HKfVn1Vpj2zbieR4A8/kcETF1Pp/zv+J5HqK15na7ISKUSiWiKKJUKiEinE4nAGq1mgHXajUDaLVayGAwQGtNouQ7vdPpMJvNUspEhH6/nwYopYjjOAWI4xilFFEUISLMZjMTpJT6ALTWXC4XMpkMx+MRgOPxSCaT4XK50Ol0mE6nKXij0fgAWq0WAMPhMCVzOBwC0G638X3fBCulaLfbPwEAm80GEWGz2Zg513V/eOC67u8KLMtCRLAsyyhYLBZUq1UTXK1WWSwWaQ/u9zsiApBqr9crr9fLnJqoeTweH8B4PObr64vJZJICTCYTcrkcIsLz+SQMQ8Iw5Pl8IiKcz2e01u9nbDabJni5XBpIvV43yZRcAeBwOLDf79+ZmHjQ6/XIZrMAFAoFut2uMXK1WlEulymXy6zXazOfMrFYLNLr9QDodrsUi0WzsVKpsN1u2e12OI6TBiQpnMhLyvfxX33P8xDHcd7fUoQgCFBKEQQBIoJt22ZtNBoxGo0QEfL5PEEQYNs2/wB6OZwvN52TQwAAAABJRU5ErkJggg==',
            'url'   => 'http://xkcd.com/1332/',
            'tags'  => [
                'xkcd',
                'webcomic',
                'slope',
                'respect',
            ],
            'description'  => null,
            'dateCreated'  => 1463687035,
            'public'   => null,
        ],
        [
            'name' => 'Garkov -- Garfield + Markov chains -- Josh Millard',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAVklEQVQ4jb2PwQ0AIAgD2YlpO62+jIAEozWS9NOWU0REGilvjKmWQscbqlpCkmwGTwHWix0KYPMtIHv1PyCesgXYyQBJvpaOBMABAByJB9AnkMvzB7fqX6rPpXaHM3oAAAAASUVORK5CYII=',
            'url'   => 'http://joshmillard.com/garkov/',
            'tags'  => [
                'garfield',
                'markov',
                'language',
                'parody',
                'comic',
            ],
            'description'  => null,
            'dateCreated'  => 1463687585,
            'public'   => null,
        ],
        [
            'name' => 'Fractal Flowchart - Spiked Math',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAA3NCSVQICAjb4U/gAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1MzmNZGAwAAALFJREFUOE+9krsNgDAMRGFj5mAESlo2QGIFJOhoItG5I11KuLPNR1SkwUphObnTO0NZNVORVRBknSLrNXH+E6zzbhVbSzXEs1/6bZ8Hj2pIfH2NDLINEKe+m6pOBG1Yba4Cjk5jXxpdUXCpx8Ruk/oWNH59I9EiCTRBoJQQL8f3lkAi48IAsGQMAwOz4inSMxN7CBgA0EavMG7kGdyJbrTXa92B631pmvvHD/f1F8xGOgADBfMg/DYL2AAAAABJRU5ErkJggg==',
            'url'   => 'http://spikedmath.com/570.html',
            'tags'  => [
                'math',
                'fractal',
                'flowchart',
                'chart',
            ],
            'description'  => 'Fractal Flowchart - Spiked Math Comic - A daily math webcomic meant to entertain and humor the geek in you...',
            'dateCreated'  => 1463687722,
            'public'   => null,
        ],
        [
            'name' => 'Programming in Lua',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAa0lEQVQ4jc1SQQ7AIAzi6TytP2MHs7h1zNqdRtLEqCDUAk1EhAAKoMa6Depe+Zj5AjX2CgFHdEI2wopMUifI7ObV1qyMR+7KuhNILurc1wim+3XzfP1GYOf/14P1ycXG+DZe742yJVdCK+IBt3VGOPv7/dsAAAAASUVORK5CYII=',
            'url'   => 'http://www.lua.org/pil/',
            'tags'  => [
                'lua',
                'script',
                'cpp',
                'dev',
            ],
            'description'  => null,
            'dateCreated'  => 1463686379,
            'public'   => null,
        ],
        [
            'name' => 'The Most Important Object In Computer Graphics History Is This Teapot - Facts So Romantic - Nautilus',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAoUlEQVQ4jaXTsQ2DMBAF0KspLCagyE6swApZISMwQwawhF3ABGlo0tDQpIno0lD8T4GI5FDEPp90heWvJ/nkE/QV4Yyu+4qCriCs6LorKHBGDzgTAnx7HoWxCcL8TPvF3MYBXBfClxnATzgNOMIk8agVwNySr/sXgy/TAQwXcl3283RTAFaIseGpkoA/g40CgqeoACvE8xoH6L5y9jJlrvMGy2MMt2SxDwkAAAAASUVORK5CYII=',
            'url'   => 'http://nautil.us/blog/the-most-important-object-in-computer-graphics-history-is-this-teapot',
            'tags'  => [
                'teapot',
                '418',
                'computer',
                'graphics',
                'image',
                'sythesis',
            ],
            'description'  => 'Let’s play a game. I’ll show you a picture and a couple videos—just watch the first five seconds or so—and you figure out&amp;#8230;',
            'dateCreated'  => 1463686613,
            'public'   => null,
        ],
        [
            'name' => 'Hg Init: a Mercurial tutorial by Joel Spolsky',
            'image'  => null,
            'url'   => 'http://hginit.com/',
            'tags'  => [
                'hg',
                'mercurial',
                'version',
                'control',
                'scm',
                'python',
                'tutorial',
            ],
            'description'  => 'A friendly introduction to the Mercurial DVCS by Joel Spolsky',
            'dateCreated'  => 1463686747,
            'public'   => null,
        ],
        [
            'name' => 'Announcing Pony Mode – a Django editing mode for Emacs « Deadpan Sincerity',
            'image'  => null,
            'url'   => 'http://blog.deadpansincerity.com/2011/05/announcing-pony-mode-a-django-editing-mode-for-emacs/',
            'tags'  => [
                'emacs',
                'editor',
                'django',
                'pony',
                'python',
                'mode',
            ],
            'description'  => null,
            'dateCreated'  => 1463686825,
            'public'   => null,
        ],
        [
            'name' => 'Heroic Programming',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACn0lEQVQ4jWWTS0iUURTHP9rWQnBly6hFRb4QXLqQNhEhIYS6GiTMQTLpIYpvaUxFbRIXodaEOgvN8YHhqAgqNioKhZiJyiyahYMzOFrofH7fvffXYh5q3dW5h/O/55x7fkcjepRSAASDBuGwGfdF3VFbAQopJVJKADSlFFIqDMNEKbDbO+jqsqGUwjAMQHH+xBLFbC12MU0DAI9nmra2BgAMw0Cps+xSCgB2dr7j8+1GKtB1id8fjgoEx8e/6e7+gGkaCGFimgIhRFx8dBSkqektKyt+QiGJpuun5OY+ZGJiAoDd3RA2WyW6fvxP6RAI+GlsfMrk5Ges1uc4HONoUkq2t7+Rk3OX5eUpTBMqKqrY3w+wsDDH9PQgLpeTqqo3WCwPyMi4SknJI3Jz72G329GUEkipWF/fpKDAQl1dNVlZGTQ3v6S0tA6nc4DV1UW83j3W179itZawtrZEa2s1weAJWigEbvcv/H7F3p6kv/8jhYU5BAJ7ABwcwOjoIABOZx8WywuGhtw4HO8BiWYYCiEAZLzf9vbXCGEwO+umsvIVZWXPaGioY2fnB0lJV8jLy+L0NIyU8TGq6E8rtra2sNka8HjmqK8vx+f7SSgkSEm5RlHRY9LSrjM19QUAIQRabM5CRECamRmluNhCfX0HBwcBAA4PJZmZKaSl3WJsbD4qjsSfA0kAiqWlTWpqaqitfcLGRhCvV2dgoJf09JuMjHQjpRkVR7DWzihT6PoxHs8cnZ19tLR0Mj7uIj//PqmpNxgedscTxXCOoxxbjKOjP9TWWnG5hkhIuExy8h2yszNZXl6Mknp6QXxhmZSSOByfSEy8hMWST3LybcrLG9H1k3jPF7eSswciVQjm50fo7e2mp+cd4XA4HiQic/5PDPAXI19ss5HTgrUAAAAASUVORK5CYII=',
            'url'   => 'http://c2.com/cgi/wiki?HeroicProgramming',
            'tags'  => [
                'wikiwikiweb',
                'deadline',
                'rush',
            ],
            'description'  => null,
            'dateCreated'  => 1463687380,
            'public'   => null,
        ],
        [
            'name' => 'Welcome — Statistics Done Wrong',
            'image'  => null,
            'url'   => 'http://www.statisticsdonewrong.com/',
            'tags'  => [
                'statistics',
                'best-practices',
                'donot',
                'data',
                'analysis',
            ],
            'description'  => null,
            'dateCreated'  => 1463687501,
            'public'   => null,
        ],
        [
            'name' => 'kafene/netscape-bookmark-parser: a php script (function) to parse netscape format bookmark files',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABrElEQVQ4jY2Sv2pUURDGv7vZ4p77J2dmvnO42ihaK1gEXSKEPIDgC/gC9mJvYW1noliF9OIjbGGeISsSSGUhkRhw12Dg2Oxd7l5114Fpzpnv45sfA/SqqqodVd0jOaHZBc0uSE5Uda+qqp3+fLc2KHLQxJhWNUUOAGz8ITazo3Xits3saMmEIodNjMlExs65+wBe1HX9mWbHNDsO5AzAMwAPTGQ8T3IIAHDOjVpnVd1vUQAoumgAZACgqvvtvHNuhO7eRVFsrYI0h7y7xCOYnTQxJppd5nl+a51Bnuc3A/mziTEFsxMEctbEmEierhMvmJGnTYwpkDMEcjo3OAcw+A/9gGbf5wZTkJy0O4nI43Xquq4fLRiQnxDN3sUQEoAr2dz8VTv38J9i57YD+aVzD29RluU9X/sE4BLA2WAwSFmWTZ1zo1Y4HA53syz72j8oVb0LAAghvGliTBVwpyzLJ76ux977261BURRbItK/xldL8UxkTLNvqnoDgPTTB/LHYnfV93/dkeRrml3R7AzA9c7XtUVs71+upKzePzezjwCsffPeK0U+qOrT/vxvewCKQLKaviEAAAAASUVORK5CYII=',
            'url'   => 'https://github.com/kafene/netscape-bookmark-parser',
            'tags'  => [
                'github',
                'netscape',
                'parser',
            ],
            'description'  => 'netscape-bookmark-parser - a php script (function) to parse netscape format bookmark files',
            'dateCreated'  => 1463686279,
            'public'   => null,
        ],
        [
            'name' => 'Survive The Deep End: PHP Security — Survive The Deep End: PHP Security :: v1.0a1',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAAcElEQVRIiWN0C4xgoCVgoqnp9LCABc5yCwjHo27XhpUQxpxpk4kxNyUrF8IYTkEEB/DQYMAdbvAQgANcQTf0g2gg4gB/eoUAIhMrwzANotFkSmcLRpMpQYAliIgBo8mUioDMOBhJyXToW8A42vglBAAK9B5UoZWPRQAAAABJRU5ErkJggg==',
            'url'   => 'http://phpsecurity.readthedocs.io/en/latest/index.html',
            'tags'  => [
                'security',
                'best-practices',
                'web',
            ],
            'description'  => null,
            'dateCreated'  => 1463686400,
            'public'   => null,
        ],
        [
            'name' => 'Chocolate Consumption, Cognitive Function, and Nobel Laureates - Chocolate consumption cognitive function and nobel laurates (NEJM).pdf',
            'image'  => null,
            'url'   => 'http://www.biostat.jhsph.edu/courses/bio621/misc/Chocolate%20consumption%20cognitive%20function%20and%20nobel%20laurates%20%28NEJM%29.pdf',
            'tags'  => [
                'chocolate',
                'research',
                'wtf',
                'statistics',
                'nobel',
            ],
            'description'  => null,
            'dateCreated'  => 1463687466,
            'public'   => null,
        ],
        [
            'name' => 'How to run a meetup without giving up your life',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB2ElEQVQ4jaWTzWtTQRTFn6DV+hHTpC9+FFz3DxBEEURsmpjmvbyWVlcKRV10IVRqRQShUpCiIEglK92UCqIi0o0Kou2iC10UxZ3gXyCCIijv3pn3czFJeJWUCA5cmI97zj135oyntV7+J7xOCRLm2847EkiYR2q9aFTYELwhgUv20TCPlLqRoAeN/H9T0EySahYZ2YdeLmLuXkRG+5CmshSR1xZc85FKBlOfwq48xcxPEh/2kFK3U5bK9daBI99VOb4JvVLGvn6IefsYu/wEszCLTpeQSgYJcq5omHcELXA1i5zciXlwHbu6hH25SPL9K8mPb5hn85h7l9Bb55Agl1LQuDCp7EKqPdjVJRIg+fWTRGLM4k2n6phHfNRDrw6h02XiQdeOUxDkkNH92PevHDj+TWIMOjdOfMRDyjvQkb2uyJl+dGYMGdyGRgU8jQrEA13ozBgACW6YhVnk/EHsl0+Y+hRS3Op6v30BmTjkSFsKqlnk1AHsm0fYD8skn9cwz+uY+9ewH1ew715g7kygc+PojdPI2X5kaHf6DhptFLuccSoZdHgPMrAFObEZKW93LQS5VmVNP2PLGMOF9dZtriMfCRtP13CkpI0ktfZe/3tP2px1/I2d4g+H84qrnd//IAAAAABJRU5ErkJggg==',
            'url'   => 'http://whistlestudios.com/2016/03/how-to-run-a-meetup-without-giving-up-your-life/',
            'tags'  => [
                'meetup',
                'presentation',
                'event',
                'community',
            ],
            'description'  => 'If running a Meetup feels like a full-time job, you&#39;re probably doing it wrong. Volunteering is important and you can make it work with some smart maneuvering.',
            'dateCreated'  => 1463686521,
            'public'   => null,
        ],
        [
            'name' => 'samhocevar/wincompose: Compose Key for Windows',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABrElEQVQ4jY2Sv2pUURDGv7vZ4p77J2dmvnO42ihaK1gEXSKEPIDgC/gC9mJvYW1noliF9OIjbGGeISsSSGUhkRhw12Dg2Oxd7l5114Fpzpnv45sfA/SqqqodVd0jOaHZBc0uSE5Uda+qqp3+fLc2KHLQxJhWNUUOAGz8ITazo3Xits3saMmEIodNjMlExs65+wBe1HX9mWbHNDsO5AzAMwAPTGQ8T3IIAHDOjVpnVd1vUQAoumgAZACgqvvtvHNuhO7eRVFsrYI0h7y7xCOYnTQxJppd5nl+a51Bnuc3A/mziTEFsxMEctbEmEierhMvmJGnTYwpkDMEcjo3OAcw+A/9gGbf5wZTkJy0O4nI43Xquq4fLRiQnxDN3sUQEoAr2dz8VTv38J9i57YD+aVzD29RluU9X/sE4BLA2WAwSFmWTZ1zo1Y4HA53syz72j8oVb0LAAghvGliTBVwpyzLJ76ux977261BURRbItK/xldL8UxkTLNvqnoDgPTTB/LHYnfV93/dkeRrml3R7AzA9c7XtUVs71+upKzePzezjwCsffPeK0U+qOrT/vxvewCKQLKaviEAAAAASUVORK5CYII=',
            'url'   => 'https://github.com/samhocevar/wincompose',
            'tags'  => [
                'github',
                'windows',
                'compose',
                'character',
                'keyboard',
                'input',
            ],
            'description'  => 'wincompose - Compose Key for Windows',
            'dateCreated'  => 1463686711,
            'public'   => null,
        ],
        [
            'name' => 'Sysadmin Purity Test',
            'image'  => null,
            'url'   => 'http://www.bofh.net/sl_Purity.html',
            'tags'  => [
                'sysadmin',
                'test',
                'unix',
                'linux',
                'network',
                'security',
            ],
            'description'  => null,
            'dateCreated'  => 1463686863,
            'public'   => null,
        ],
        [
            'name' => 'How To Ask Questions The Smart Way',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACOklEQVQ4jY2SzUtUYRjFz0wItmgXbqR/wUVEtGklbty4SRchLmwZ1KKoHKZRDFJmIUrD2CLdTOhY4KLBHGa6ca/zpXdm7pV7h9AWIhEEQetAvf1aTDNmGvXAWbzv88F5znmkM8Iw8hhGnn/9nRmtolptDstaxbJWMc0MjhPn9/yZUSisIEnlcopqNUGtNsfu7m1qtTlsO4llrWIYeUwzc5JN61Gvz9BojFGvz+C603jeODs7d/G8GLadxHHiVCoLNBpjp9mY5hssa5V6fQbPi+E4cQqFFTKZLMXiMtXqLK47hedNtNf6rTmDaWZw3WkcJ45tJ5GkpaVNurq+k0ptIUm2nWR7+ymuO31ShxatajWBbSfJ5QwkaWDgE1JAf/9nJCmXM3CcONVqAs8bZ2vrOSeGeN4EpdIikjQ/v4kU0BE6QApIPGuyKJUW8bwJyuXUsZCGkf+1+/GAK5e/IgVt9PR8Q5KKxWV8P3q8RjZrUS6ncJw4rjuF7y/yOPYBKeBqaIshpekL55ACHj7axfcX8f37+H6USmWBtv8bG6+RpLdrFhe7D7mnaaKhSa6pTDQ0STT0hAvdkF17T2vl9oAWE0m6NfoRKSAefsALjTKrO7zSDW6Gl5ACmnlpfb10+iLT6SLnOw/b4vWFcwwpzXVZXFLTkc7OI16m/mjO598hSU27mkUdoQN07scJdHQcIQX09n5p29qm3hLufxGLeU0WraOJRBoMDu4zMrLH8PDfMTKyx+DgPpFIA0n6CaTTAubTaAiPAAAAAElFTkSuQmCC',
            'url'   => 'http://catb.org/~esr/faqs/smart-questions.html',
            'tags'  => [
                'question',
                'faq',
                'bug',
                'report',
                'dev',
                'support',
            ],
            'description'  => null,
            'dateCreated'  => 1463687293,
            'public'   => null,
        ],
        [
            'name' => 'Opt out of global data surveillance programs like PRISM, XKeyscore, and Tempora - PRISM Break - PRISM Break',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAAAAAA6mKC9AAAAVklEQVQY02NgIAU4saBwebeUMyPz/b5PRJFv+t+BzDU5+N8Pma95////FRVRGnABbu3Q1v//vzogK+L4f1QOmR/xfwGKHUkfs5G5TNGb9VHkuYJI8iEArKwXyBGzk/kAAAAASUVORK5CYII=',
            'url'   => 'https://prism-break.org/en/',
            'tags'  => [
                'prism',
                'break',
                'privacy',
                'self-hosted',
                'web',
                'service',
            ],
            'description'  => 'Opt out of global data surveillance programs like PRISM, XKeyscore and Tempora. Help make mass surveillance of entire populations uneconomical! We all have a right to privacy, which you can exercise today by encrypting your communications and ending your reliance on proprietary services.',
            'dateCreated'  => 1463687628,
            'public'   => null,
        ],
        [
            'name' => 'minecraft - Is it dangerous to go extreme pig riding in a thunderstorm? - Arqade',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAkElEQVQ4jeWSPQ6AMAiFO7WTt2DxBt3awat4OVeO5W7SCRdJgFJjYpx8SRegXx4/IXypCKVFKO1PgCNnsp8tRNZ0muZFAeiSBLiOmGoL7wDKCQetbQmw7SgnMoiIhIiUoPJ/SlCJ40MAvyeAbjsRSlu3XSUtQOa41gV4s7C9uwBv3xwb3Uc3RG+9o8N5deJSJwZNzji30evlAAAAAElFTkSuQmCC',
            'url'   => 'http://gaming.stackexchange.com/questions/21261/is-it-dangerous-to-go-extreme-pig-riding-in-a-thunderstorm',
            'tags'  => [
                'minecraft',
                'game',
                'indie',
                'pig',
                'wtf',
            ],
            'description'  => null,
            'dateCreated'  => 1463687183,
            'public'   => null,
        ],
        [
            'name' => 'Most visited',
            'image'  => null,
            'url'   => 'place:sort=8&maxResults=10',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
        [
            'name' => 'Getting Started',
            'image'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAz5JREFUeNpcU0toXFUY/s49596588ikySSmM8rk0UkJEirVTVEjYk1NUdRFFgouXZQI2k2hUCjdiYIuCi4Kuig0DbqQYgU3Yi0iFRuRCBMwaZvMZDTNY95z3/fM8b8jldpzOeeee/i/737n+/+f4ZExf730rkiaZ9NJMx/nmk5HypMqqLr+ZuD4F67N5ZYejmfRsnvhyKsLhSs3zP70SubgYKHSdFENu+gXAprQIGnvBi5ez0m1b6u7M399+PTx+UvtCKtFi2F6195qXK2byir88esy5ksfYND5DhuhRCtUKBNB0Q7w5Z8ee2GgWdjOn250fn5v5j8F5dOHlZD0kWRgAwp3hrKY0S9BJWKIcQ5PShhNG4+1bHx+IocT+RXcrRSDMfFNRvvt3Oyp/icIrRhUl9hoO4kt3F55Bxf3LkLV20jWOohbDjzXxyc/lMH0cRSyCd1xq+dFhu986t7T0CUwIzB8EkW3O5ibhj44ib7NJhiBKRoB/aS4ZWHjbxtjGQYP7nGRTjim1SaQqYiAVAREpHG8vzWJn+6PQ6CF0HPR7nQQczpYeEWHyWMUkwU8MSECGwgJxAWp9xWKNzkuH3oet+JDlIE9Momedh1G4CN0bfhVG9nsS0BQQthJx0V7j3elq7ihqV5ezQTwZmodP9ZGkU/bOPr4Nr53xtDYsaD7Dg4nNqFaH5OCYSSdGhf7daNmuv6wEKqXk/yExKGBHSznFsH6FFpKQ/JAA0ulUejWLt44lkHXsqDaX6C6Nl4Rnq8vK8s/KThDMlJhkI91YOO+iR3XwEelCdTCBLSgijNzd6DLNfhlHfZ6FtWiWBQpq/V2LdSrrNPljBQkoOjuCiPxAMutOIbkPqYSEqeequGZaTLzdhZhS0PlnlB9bvhtr5CuHj3y2Qj8hVQ/kEopxONEEsO/0yATDYXYAdWrE69JEElXq7Hyk0tro+xBU1yZmr4xrIcvptIRCZlJJAYBmRGRkD08aivA7VDvWPqt564Xn41w/AHB1/u7l1/uGxGU8mNcgodUNDIq0JDeLnpzc1uo1Qr76rWbqyf/142PjsXJqdkmN2YDnQ9oGkJNU+t57q7qUv4y9/t64+HYfwQYAN7OczrzUDvGAAAAAElFTkSuQmCC',
            'url'   => 'https://www.mozilla.org/en-US/firefox/central/',
            'tags'  => [],
            'description'  => null,
            'dateCreated'  => 1460294956,
            'public'   => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse flat Firefox bookmarks (no directories).
     */
    public function testParseFlat(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/firefox_flat.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse nested Firefox bookmarks (directories and subdirectories).
     */
    public function testParseNested(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/firefox_nested.htm');
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
