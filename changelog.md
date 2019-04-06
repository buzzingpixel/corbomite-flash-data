# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.0] - 2019-04-06
### Added 
- 100% PHPUnit code coverage testing
- Internally now using [Doctrine coding standards](https://github.com/doctrine/coding-standard)
- Interface definitions have been added to the DI
### Changed
- Stopped using now deprecated calls in Corbomite DI
- `APP_BASE_PATH` constant is no longer required to be defined and will be determined automatically based on the location of the projects Vendor directory
- Now using buzzingpixel/cookie-api 2.x

## [1.1.0] - 2019-01-22
### Changed
- Update guid column to store as binary

## [1.0.3] - 2019-01-22
### Fixed
- Update table to not use auto-increment integer as primary key

## [1.0.2] - 2019-01-15
### Fixed
- Fixed a flash data key cookie bug that could cause an error to be thrown

## [1.0.1] - 2019-01-14
### Fixed
- Fixed a bug where the api did not pass in the clear data argument on get flash data method
- Fixed issue with variables passed by reference (weird stuff)

## [1.0.0] - 2019-01-14
### New
- Initial Release
