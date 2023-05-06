# `CHANGELOG.md`

This file keeps track of the changes made to the project. While it might not always succeed in doing so, I will attempt
to follow a somewhat simplified form of the conventions outlined by 
[Keep A Changelog](https://keepachangelog.com/en/1.0.0/) and [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Instead of "Added", "Fixed", "Changed", "Removed"; I will consider everything a change and only highlight when a change
is a breaking change, a new feature or a bug fix. New releases will also follow this convention; `MAJOR.MINOR.PATCH`,
where `MAJOR` is incremented when a breaking change is made, `MINOR` is incremented when a new feature is added and
`PATCH` is incremented when a change is made that does not affect functionality (cosmetic fixes, formatting,
optimization) or when a bug is fixed.

## [2.0.0] - 2023-05-06

- **BREAKING**: `PHP` version requirement has been bumped to `^8.0`.
- `composer.lock` added to `.gitignore` file.
- `.php-cs-fixer.cache` added to `.gitignore` file.
- Development dependency `brekitomasson/php-cs-fixer-breki-config` added and configuration file created.
- Development dependency `phpstan/phpstan` added and configuration file created.
- Exception classes renamed.
- Added new feature `getOutcome($index)`.
- Internals refactored to make use of `PHP 8.x` features.
- PHPUnit replaced with Pest and test suite refactored accordingly.

## [1.0.0] - 2020-09-21

- Initial release version with all major features implemented.