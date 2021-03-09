# TelegramBot-PHP

[![API](https://img.shields.io/badge/Telegram%20Bot%20API-5.0%20--%20November%204%2C%202020-blue.svg)](https://core.telegram.org/bots/api)
![PHP](https://img.shields.io/badge/php-%3E%3D7.2-8892bf.svg)
![CURL](https://img.shields.io/badge/cURL-required-green.svg)

[![Latest Stable Version](https://poser.pugx.org/lukasss93/telegrambot-php/v/stable)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![Total Downloads](https://poser.pugx.org/lukasss93/telegrambot-php/downloads)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![License](https://poser.pugx.org/lukasss93/telegrambot-php/license)](https://packagist.org/packages/lukasss93/telegrambot-php)

> A very simple PHP [Telegram Bot API](https://core.telegram.org/bots/api) for sending messages. 

Requirements
---------

* PHP >= 7.2
* Curl for PHP must be enabled.
* Telegram API Key, you can get one simply with [@BotFather](https://core.telegram.org/bots#botfather) with simple commands right after creating your bot.

For the WebHook:
* An SSL certificate (Telegram API requires this). You can use [Cloudflare's Free Flexible SSL](https://www.cloudflare.com/ssl) which crypts the web traffic from end user to their proxies if you're using CloudFlare DNS.    
Since the August 29 update you can use a self-signed ssl certificate.

For the GetUpdates:
* Some way to execute the script in order to serve messages (for example cronjob)

Installation
---------
You can install this library with composer:

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
For instance you can arrange a ReplyKeyboard using this code:
```php
$buttons = [ 
    //First row
    [
        $bot->buildKeyboardButton("Button 1"),
        $bot->buildKeyboardButton("Button 2")
    ], 
    //Second row 
    [
        $bot->buildKeyboardButton("Button 3"),
        $bot->buildKeyboardButton("Button 4"),
        $bot->buildKeyboardButton("Button 5")], 
    //Third row
    [
        $bot->buildKeyboardButton("Button 6")]
    ];
    
$bot->sendMessage([
    'chat_id' => $chat_id, 
    'reply_markup' => $bot->buildKeyBoard($buttons), 
    'text' => 'This is a Keyboard Test'
]);
```
When a user click on the button, the button text is send back to the bot.
For an InlineKeyboard it's pretty much the same (but you need to provide a valid URL or a Callback data) 
```php
$buttons = [ 
    //First row
    [
        $bot->buildInlineKeyBoardButton("Button 1", $url="http://link1.com"), 
        $bot->buildInlineKeyBoardButton("Button 2", $url="http://link2.com")
    ], 
    //Second row 
    [
        $bot->buildInlineKeyBoardButton("Button 3", $url="http://link3.com"),
        $bot->buildInlineKeyBoardButton("Button 4", $url="http://link4.com"),
        $bot->buildInlineKeyBoardButton("Button 5", $url="http://link5.com")
    ], 
    //Third row
    [
        $bot->buildInlineKeyBoardButton("Button 6", $url="http://link6.com")
    ]
];

$bot->sendMessage([
    'chat_id' => $chat_id, 
    'reply_markup' => $bot->buildInlineKeyBoard($buttons), 
    'text' => 'This is a Keyboard Test'
]);
```

This is the list of all the helper functions to make keyboards easily:
```php
$bot->buildKeyBoard(array $options, $onetime=true, $resize=true, $selective=true)
```
Send a custom keyboard. $option is an array of array KeyboardButton.  
Check [ReplyKeyBoardMarkUp](https://core.telegram.org/bots/api#replykeyboardmarkup) for more info.    

```php
$bot->buildInlineKeyBoard(array $inline_keyboard)
```
Send a custom keyboard. $inline_keyboard is an array of array InlineKeyboardButton.  
Check [InlineKeyboardMarkup](https://core.telegram.org/bots/api#inlinekeyboardmarkup) for more info.    

```php
$bot->buildInlineKeyBoardButton($text, $url, $callback_data, $switch_inline_query)
```
Create an InlineKeyboardButton.    
Check [InlineKeyBoardButton](https://core.telegram.org/bots/api#inlinekeyboardbutton) for more info.    

```php
$bot->buildKeyBoardButton($text, $url, $request_contact, $request_location)
```
Create a KeyboardButton.    
Check [KeyBoardButton](https://core.telegram.org/bots/api#keyboardbutton) for more info.    


```php
$bot->buildKeyBoardHide($selective=true)
```
Hide a custom keyboard.  
Check [ReplyKeyBoarHide](https://core.telegram.org/bots/api#replykeyboardhide) for more info.    

```php
$bot->buildForceReply($selective=true)
```
Show a Reply interface to the user.  
Check [ForceReply](https://core.telegram.org/bots/api#forcereply) for more info.

Contact me
------------
You can contact me [via Telegram](https://telegram.me/Lukasss93) but if you have an issue 
please [open](https://github.com/Lukasss93/telegrambot-php/issues) one.

To-Do list
----------
* Optional predictive parameters in methods
* Optimize keyboards
* Chat conversations
* Commands listener with callback + events

Changelog
------------
All notable changes to this project will be documented [here](https://github.com/Lukasss93/telegrambot-php/blob/master/CHANGELOG.md).

### Recent changes
## v1.12 - 2021-03-10
### Changed
- Updated to Telegram Bot API 5.1