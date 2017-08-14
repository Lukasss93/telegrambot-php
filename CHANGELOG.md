# Changelog
All notable changes to this project will be documented in this file.

## [1.5.0]
### Added
- Added new `endpoint` method to call api methods manually
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
    - Return `Message[]`
    
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
