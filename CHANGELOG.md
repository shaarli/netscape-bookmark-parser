# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

**Please read the changelog carefully, this is a major release, there are breaking changes.**

### Added
- `NetscapeBookmarkEncoder` and `NetscapeBookmark.Decoder` classes.
- CHANGELOG.md and contributor CODE_OF_CONDUCT.md.
- github ISSUE_TEMPLATE.md for bug reports and feature requests.
- `supportsDecoding` method and `self::FORMAT` class constant (for future Interface conformity and Symfony services integration).
- `BookmarksDataFormatter` class to use before export to have bookmarks ordered by tag.
- `BookmarksDataConverter` and `LegacyBookmarksDataConverter` class to convert old bookmarks to new data format.
- PHPUnit configuration file: phpunit.xml.dist

### Changed
- Remove `Katzgrau-KLogger` dependency.
- `parseBoolean` method should always return a boolean value.
- Renamed properties to be compatible with "https://schema.org" structured data vocabulary:
```php
[
    'title' => 'name',
    'icon'  => 'image',
    'uri'   => 'url',
    'tags'  => 'tags',
    'note'  => 'description',
    'time'  => 'dateCreated',
    'pub'   => 'public'
];
```
- Constructor: Replace parameters from constructor with `$context` array and class constants.
- Updated PHPUnit to the latest version (9.5).
- Undefined values should remain `null`
	- Decoder should not set default `$item['name'] = 'untitled'`.
	- Decoder should not set `$item['dateCreated'] = time()` as default.
- Removed default Tags ; This is not the decoder job to set default values.
- Removed default public/private status ; This is not the decoder job to set default public status.
- Moved source files and updated file structure.
- Travis CI replaced with GitHub actions.
- Updated PHPCS linter configuration.
- Updated README.md
- Improved `Makefile`.

### Fixed
- TRUE_PATTERN yes appears twice; ordered alphabetically.

### Removed
- Drop support for PHP < 7.3. PHP 7.1 and 7.2 have reached end of life.
- travis.yml, .editorconfig, .gitattributes
- `NetscapeBookmarkParser` should be removed next major release.

## [v3.2.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v3.2.0) - 2021-02-22

### Added
- Parsing 'ICON' attribute.

### Fixed
- Improve PHPCS linter configuration

## [v3.1.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v3.1.0) - 2021-01-25

### Changed
- Scale down 'items' variable scope to method level. Class is now stateless.
- Refactor 'parseString' method
- Replaced idle 'sanitized' variable in 'sanitizeString' method

## [v3.0.2](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v3.0.2) - 2021-01-17

### Fixed
- Remove unknown parameter in `parseBoolean` function calls

## [v3.0.1](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v3.0.1) - 2020-11-03

### Added
- README: installation section (composer)

### Fixed
- README: fix default example with v3.0.0 values

## [v3.0.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v3.0.0) - 2020-11-03

**Please read the changelog carefully, this is a major release, there are breaking changes.**

### Added
- Parsing now supports tags with multiple words separated by whitespaces.
- Official PHP compatibility with PHP 7.3, 7.4 and 8.0.
- Follow and enforce PSR-12 coding style

### Changed
- **Bookmark's tags now returns an array of tags instead of tags string separated by whitespaces.**

### Removed
- Drop support for PHP 5.6 and 7.0.

## [v2.2.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.2.0) - 2020-06-06
### Added
- Support Shaarli extended format: allow <a> tag in bookmark description

### Changed
- Log to current working directory by default instead of library path
- Do not replace tab character to preserve bookmarks formatting

### Fixed
- Error while trying to import a file without bookmarks
- Undefined time variable

## [v2.1.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.1.0) - 2018-10-06
### Added
- Add PHP 7.1 and 7.2 to the Travis test environments
- Add support for microsecond timestamps

### Changed
- Update test dependencies
- Update regexes to PCRE2 for PHP 7.3

### Removed
- Drop support for PHP 5.3.x, 5.4.x and 5.5.x

## [v2.0.5](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.5) - 2018-01-30
## Fixed
- Fix scuttle description on multiple lines
- Improve sanitizing regexp, preventing trimming actual content

## [v2.0.4](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.4) - 2017-07-30
### Changed
- Pin Travis builds to `precise` to ensure PHP 5.3 compatibility

## [v2.0.3](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.3) - 2017-07-30
### Changed
- Update nested folder name parsing to sanitize resulting tags

## [v2.0.2](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.2) - 2017-06-10
### Changed
- Update note/description parsing to support Scuttle exports

## [v2.0.1](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.1) - 2017-03-08
### Changed
- Allow specifying the log directory

## [v2.0.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v2.0.0) - 2017-02-19
### Added
- Log import into a log file

### Changed
- NetscapeBookmarkParser class is now under `Shaarli` namespace.

## [v1.1.1](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v1.1.1) - 2017-02-15
### Added
- Add `CHANGELOG.md`
- Enable Composer cache for Travis builds

### Fixed
- Keep Composer metadata in Git-generated archives

## [v1.0.1](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v1.0.1) - 2016-08-09
### Changed
- Mark this repository as being a friendly fork maintained by the Shaarli community
- Add/update CI badges

### Fixed
- Support exports from legacy Shaarli versions (i.e. before the export refactoring)

## [v1.0.0](https://github.com/shaarli/netscape-bookmark-parser/releases/tag/v1.0.0) - 2016-08-09
### Added
- Add unitary tests using [PHPUnit](https://phpunit.de/)
    - Browser dump coverage: Chromeium, Firefox, Internet Explorer
    - Web service dump coverage: Delicious, Shaarli Community
- Add [Travis CI](https://travis-ci.org/) automated builds
- Add PHP 5.3 compatibility (use `array()` instead of the short `[]` syntax)

### Changed
- let Git homogenize line endings to make tests portable
- update Composer/Packagist metadata
- refactor the parser as a class to help splitting logic and improve readability
    - better date format support
    - multi-line descriptions
    - refactor and simplify input sanitizing
