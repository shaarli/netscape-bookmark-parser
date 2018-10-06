# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

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
