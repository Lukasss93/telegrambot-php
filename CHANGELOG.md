# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.7.1] - 2020-03-31
### Changed
- Updated to Telegram Bot API 4.7
- Improved PHPDocs

## [1.7] - 2020-03-18
### Changed
- Added support for **PHP 7.2+**
- Updated to Telegram Bot API 4.5 + 4.6
- Improved PHPDocs
- Updated code indentation to PSR-12 standard
- Updated LICENSE file
- Updated CHANGELOG file using [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)

### Fixed
- Missing fields in some types

### Removed
- Dropped support for **PHP 5.6**

## [1.6.14] - 2019-08-01
### Changed
- Updated to Telegram Bot API 4.4

## [1.6.13] - 2019-06-01
### Changed
- Updated to Telegram Bot API 4.3
- Updated PHPDocs

### Fixed
- Missing `poll` variable inside Message class

## [1.6.12] - 2019-04-14
### Changed
- Updated to Telegram Bot API 4.2

## [1.6.11] - 2018-08-28
### Added
- Added `clearUpdates()` custom method (it's an alias for `getUpdates(-1)`)
- Added `TelegramLimits` class constants to get the download/upload file limit

### Changed
- Updated to Telegram Bot API 4.1
- You can now pass an interger to `getArgs()` method to get the string at the array index position

## [1.6.10] - 2018-08-22
### Fixed
- Fixed `JsonMapper Exception` PHPDoc message in all methods
- Fixed exception using `sendMessage()` method + split message feature with unicode strings
- Missing php extensions in *composer.json* file

## [1.6.9] - 2018-07-28
### Added
- Added *MessageEntityTypes*, *PassportSources*, *PassportTypes* classes in constants namespace

### Changed
- Updated to Telegram Bot API 4.0
- Updated LICENSE file
- Updated PHPDocs in methods
- Updated code indentation
- Replaced whitespaces with tabs

### Removed
- Removed unused variables

### Fixed
- Fixed JsonMapper Exception `true` type
- Fixed `pay` parameter unused in `buildInlineKeyboardButton()` method
- Missing `allowed_updates` parameter from `getUpdates()` method

## [1.6.8] - 2018-04-10
### Added
- Added `isCommand()` method to Message class

### Fixed
- Fixed JsonMapper Exception `true` type

## [1.6.7] - 2018-02-14
### Fixed
- Fixed `uploadStickerFile()` method

## [1.6.6] - 2018-02-14
### Changed
- Updated to Telegram Bot API 3.6

## [1.6.5] - 2017-11-20
### Changed
- Updated to Telegram Bot API 3.5

## [1.6.4] - 2017-10-11
### Changed
- Updated to Telegram Bot API 3.4

## [1.6.3] - 2017-09-21
### Fixed
- Fixed `getCommand()` method in Message class.

## [1.6.2] - 2017-09-17
### Fixed
- Fixed `getCommand()` method in Message class

## [1.6.1] - 2017-09-17
### Changed
- The `getCommand()` method in Message class now return `null` if `text` property isn't a command

## [1.6.0] - 2017-08-23
### Changed
- Updated to Telegram Bot API 3.3

## [1.5.2] - 2017-08-20
### Changed
- Renamed `curl_file_create_auto_mime()` function in `curl_file_create_automime()`

## [1.5.1] - 2017-08-19
### Fixed
- Fixed `curl_file_create_auto_mime()` function

## [1.5.0] - 2017-08-14
### Added
- Added new `endpoint()` method to call api methods manually
- Added *ChatActions* and *ParseModes* classes in constants namespace
- Added `splitLongMessage` property to allow splitting text with `sendMessage()` method
- Auto split very long text in `sendMessage` method
    
## [1.4.4] - 2017-08-13
### Added
- Added LICENSE file
- Added TODO list to readme
- Added changelog link to readme

### Fixed
- Fixed concatenation error 
- Fixed PHPDoc errors
- Fixed TelegramHelper not available globally

## [1.4.3] - 2017-08-12
### Added
- Added `curl_file_create()` helper function
- Added `curl_file_create_auto_mime()` helper function
- Added `is_json()` helper function

### Removed
- Removed *aurax-php* library dependence

## [1.4.2] - 2017-08-12
### Added
- Added `getType()` method in Message class

### Changed
- Renamed and fixed `getType()` in Update class

## [1.4.1] - 2017-08-09
### Added
- Added `INLINE_QUERY` type to `getUpdateType()` method

## [1.4] - 2017-07-21
### Changed
- Updated to Telegram Bot API 3.2

## [1.3] - 2017-06-30
### Changed
- Updated to Telegram Bot API 3.1

## [1.2.3] - 2017-06-12
### Added
- Added `getUpdateType()` method
- Added TelegramUpdateTypes class for `getUpdateType()` method
- Added curl_file_create_auto_mime() function

### Fixed
- Fixed `isForwarded()` method in Message class

## [1.2.2] - 2017-06-05
### Fixed
- Fixed `sendRequest()` phpdoc and post parameters

## [1.2.1] - 2017-06-04
### Added
- Added `isForwarded()` method in Message class

## [1.2] - 2017-06-04
### Changed
- Improved code

## [1.1] - 2017-05-20
### Changed
- Updated to Telegram Bot API 3.0

## [1.0] - 2017-01-24
### Added
- First commit