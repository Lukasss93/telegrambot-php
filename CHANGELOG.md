# Changelog
All notable changes to this project will be documented in this file.

## [1.6.8]
### Fixed
- Bug fix: JsonMapper Exception `true` type
### Added
- Added `isCommand()` method to `Message` Class

## [1.6.7]
### Changed
- Fixed uploadStickerFile method

## [1.6.6]
### Changed
- Updated to Telegram Bot API 3.6

## [1.6.5]
### Changed
- Updated to Telegram Bot API 3.5

## [1.6.4]
### Changed
- Updated to Telegram Bot API 3.4

## [1.6.3]
### Fixed
- Fixed `getCommand()` method in Message object.

## [1.6.2]
### Fixed
- Fixed `getCommand()` method in Message object.

## [1.6.1]
### Changed
- Now `getCommand()` method in Message object return `null` if `text` property isn't a command.

## [1.6.0]
### Changed
- Updated to Telegram Bot API 3.3

## [1.5.2]
### Changed
- Renamed curl_file_create_auto_mime function in curl_file_create_automime

## [1.5.1]
### Fixed
- Fixed curl_file_create_auto_mime function

## [1.5.0]
### Added
- Added new `endpoint` method to call api methods manually. Parameters:
    - $api `string` - api endpoint name
    - $parameters `array` - parameters as key/value array
    - $isPost=true `bool` - calling method  
- Added 2 classes in constants namespace:
    - *ChatActions* to use (if you want) in `action` parameter (sendChatAction method)
    - *ParseModes* to use (if you want) in `parse_mode` parameter
- Auto split very long text in `sendMessage` method (4096 characters per message)
    - Enable it after class instantiation:
      ```php
      $bot = new TelegramBot($token);
      $bot->splitLongMessage=true;
      ```
    - Default: `false`
    - The *sendMessage* method will return `Message[]` instead of `Message`
    
## [1.4.4]
### Added
- Added license file
- Added todo list to readme
- Added changelog link to readme

### Fixed
- Fixed concatenation error 
- Fixed PhpDoc error
- Fixed TelegramHelper not available globally

## [1.4.3]
### Added
- Added TelegramHelper file
    - `curl_file_create` function if not exist
    - `curl_file_create_auto_mime` function
    - `is_json` to check if a string is json

### Removed
- Removed `aurax-php` dependence
