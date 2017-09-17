# TelegramBot-PHP

[![API](https://img.shields.io/badge/Telegram%20Bot%20API-August%2023%2C%202017-blue.svg)](https://core.telegram.org/bots/api)
![PHP](https://img.shields.io/badge/php-%3E%3D5.6-8892bf.svg)
![CURL](https://img.shields.io/badge/cURL-required-green.svg)

[![Latest Stable Version](https://poser.pugx.org/lukasss93/telegrambot-php/v/stable)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![Total Downloads](https://poser.pugx.org/lukasss93/telegrambot-php/downloads)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![License](https://poser.pugx.org/lukasss93/telegrambot-php/license)](https://packagist.org/packages/lukasss93/telegrambot-php)

> A very simple PHP [Telegram Bot API](https://core.telegram.org/bots/api) for sending messages. 

Requirements
---------

* PHP >= 5.6
* Curl for PHP must be enabled.
* Telegram API Key, you can get one simply with [@BotFather](https://core.telegram.org/bots#botfather) with simple commands right after creating your bot.

For the WebHook:
* An SSL certificate (Telegram API requires this). You can use [Cloudflare's Free Flexible SSL](https://www.cloudflare.com/ssl) which crypts the web traffic from end user to their proxies if you're using CloudFlare DNS.    
Since the August 29 update you can use a self-signed ssl certificate.

For the GetUpdates:
* Some way to execute the script in order to serve messages (for example cronjob)

Installation
---------

* #### Manual 
    Copy **src** folder in your project, rename it and include all classes in your new bot script.
    
    ```php
    //include the entire folder first!  
    use TelegramBot\TelegramBot;
    $bot = new TelegramBot($token);
    ```
    
* #### Composer

    `composer require lukasss93/telegrambot-php`

Configuration (WebHook)
---------

Navigate to 
https://api.telegram.org/bot(TOKEN)/setWebhook?url=https://yoursite.com/your_update.php
Or use the Telegram class setWebhook method.

Informations
---------

This simple framework is object-based, all methods return a Telegram Object contained in TelegramBot/Types namespace. 

Examples
---------

```php
use TelegramBot\TelegramBot;

$bot = new TelegramBot($token);
$update=$bot->getWebhookUpdate();
$bot->sendMessage([
    'chat_id' => $update->message->chat->id,
    'text' => 'Hello world!'
]);
```

If you want to get some specific parameter from the Telegram webhook, simply call parameter name in the object:
```php
use TelegramBot\TelegramBot;

$bot = new TelegramBot($token);
$update=$bot->getWebhookUpdate();
$text=$update->message->text;
```

To upload a Photo or some other files, you need to load it with CurlFile:
```php
// Load a local file to upload. If is already on Telegram's Servers just pass the resource id
$img = curl_file_create('test.png','image/png');
$bot->sendPhoto([
    'chat_id' => $chat_id, 
    'photo' => $img
]);
```

To download a file on the Telegram's servers
```php
$file = $bot->getFile($file_id);
$bot->downloadFile($file->file_path, "./my_downloaded_file_on_local_server.png");
```

If you want to use getUpdates instead of the WebHook you need a for cycle.
```php
$updates=$bot->getUpdated();
for ($i = 0; $i < count($updates); $i++) {
    //single update
    $update=$updates[$i];
    if($update->message->getCommand()=='/start'){
        //working!
    }
}
```

Message Object Methods
------------
Message object mainly provide 2 methods:
* getCommand()

    ```php
    //$update->message->text => '/test@ExampleBot my args'
    $command=$update->message->getCommand();
    //$command => '/text'
    ```
* getArgs(bool $asString=false)

    ```php
    //$update->message->text => '/test@ExampleBot my args'
    $args_array=$update->message->getArgs();
    //$args_array[0] => 'my'
    //$args_array[1] => 'args'
    $args_string=$update->message->getArgs(true);
    //$args_string => 'my args'
    ```


Build keyboard parameters
------------
Telegram's bots can have two different kind of keyboards: Inline and Reply.
The InlineKeyboard is linked to a particular message, while the ReplyKeyboard is linked to the whole chat.
They are both an array of array of buttons, which rapresent the rows and columns.
For instance you can arrange a ReplyKeyboard like this: 
![1](https://camo.githubusercontent.com/8af69f730130d48f06c50e9c0a9684d4cc86127f/68747470733a2f2f7069636c6f61642e6f72672f696d6167652f72696c636c6377722f7265706c796b6579626f6172642e706e67)
using this code:
```php
$buttons = [ 
    //First row
    [
        $telegram->buildKeyboardButton("Button 1"),
        $telegram->buildKeyboardButton("Button 2")
    ], 
    //Second row 
    [
        $telegram->buildKeyboardButton("Button 3"),
        $telegram->buildKeyboardButton("Button 4"),
        $telegram->buildKeyboardButton("Button 5")], 
    //Third row
    [
        $telegram->buildKeyboardButton("Button 6")]
    ];
    
$telegram->sendMessage([
    'chat_id' => $chat_id, 
    'reply_markup' => $telegram->buildKeyBoard($buttons), 
    'text' => 'This is a Keyboard Test'
]);
```
When a user click on the button, the button text is send back to the bot.
For an InlineKeyboard it's pretty much the same (but you need to provide a valid URL or a Callback data) 
![2](https://camo.githubusercontent.com/ac0ce06b10f06fd76c96b780b7caaa2d96e4582b/68747470733a2f2f7069636c6f61642e6f72672f696d6167652f72696c636c6377612f7265706c796b6579626f617264696e6c696e652e706e67)
```php
$buttons = [ 
    //First row
    [
        $telegram->buildInlineKeyBoardButton("Button 1", $url="http://link1.com"), 
        $telegram->buildInlineKeyBoardButton("Button 2", $url="http://link2.com")
    ], 
    //Second row 
    [
        $telegram->buildInlineKeyBoardButton("Button 3", $url="http://link3.com"),
        $telegram->buildInlineKeyBoardButton("Button 4", $url="http://link4.com"),
        $telegram->buildInlineKeyBoardButton("Button 5", $url="http://link5.com")
    ], 
    //Third row
    [
        $telegram->buildInlineKeyBoardButton("Button 6", $url="http://link6.com")
    ]
];

$telegram->sendMessage([
    'chat_id' => $chat_id, 
    'reply_markup' => $telegram->buildInlineKeyBoard($buttons), 
    'text' => 'This is a Keyboard Test'
]);
```

This is the list of all the helper functions to make keyboards easily:
```php
buildKeyBoard(array $options, $onetime=true, $resize=true, $selective=true)
```
Send a custom keyboard. $option is an array of array KeyboardButton.  
Check [ReplyKeyBoardMarkUp](https://core.telegram.org/bots/api#replykeyboardmarkup) for more info.    

```php
buildInlineKeyBoard(array $inline_keyboard)
```
Send a custom keyboard. $inline_keyboard is an array of array InlineKeyboardButton.  
Check [InlineKeyboardMarkup](https://core.telegram.org/bots/api#inlinekeyboardmarkup) for more info.    

```php
buildInlineKeyBoardButton($text, $url, $callback_data, $switch_inline_query)
```
Create an InlineKeyboardButton.    
Check [InlineKeyBoardButton](https://core.telegram.org/bots/api#inlinekeyboardbutton) for more info.    

```php
buildKeyBoardButton($text, $url, $request_contact, $request_location)
```
Create a KeyboardButton.    
Check [KeyBoardButton](https://core.telegram.org/bots/api#keyboardbutton) for more info.    


```php
buildKeyBoardHide($selective=true)
```
Hide a custom keyboard.  
Check [ReplyKeyBoarHide](https://core.telegram.org/bots/api#replykeyboardhide) for more info.    

```php
buildForceReply($selective=true)
```
Show a Reply interface to the user.  
Check [ForceReply](https://core.telegram.org/bots/api#forcereply) for more info.

Emoticons
------------
For a list of emoticons to use in your bot messages, please refer to the column Bytes of this table:
http://apps.timwhitlock.info/emoji/tables/unicode

Contact me
------------
You can contact me [via Telegram](https://telegram.me/Lukasss93) but if you have an issue 
please [open](https://github.com/Lukasss93/telegrambot-php/issues) one.

To-Do list
------------
![in progress](https://img.shields.io/badge/Status-In%20progress-green.svg)
* Optimize keyboards

![not started](https://img.shields.io/badge/Status-Not%20started-red.svg)

* Chat conversations
* Commands listener with callback + events

![new version](https://img.shields.io/badge/Status-New%20version%20(2.0)%20--%20WIP-blue.svg)
* Optional predictive parameters in methods

Changelog
------------
All notable changes to this project will be documented [here](https://github.com/Lukasss93/telegrambot-php/blob/master/CHANGELOG.md).

### Recent changes
## [1.6.2]
### Fixed
- Fixed `getCommand()` method in Message object.
