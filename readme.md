# TelegramBot-PHP

[![API](https://img.shields.io/badge/Telegram%20Bot%20API-July%2021%2C%202017-blue.svg)](https://core.telegram.org/bots/api)
![PHP](https://img.shields.io/badge/php-%3E%3D5.6-8892bf.svg)
![CURL](https://img.shields.io/badge/cURL-required-green.svg)

[![Latest Stable Version](https://poser.pugx.org/lukasss93/telegrambot-php/v/stable)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![Total Downloads](https://poser.pugx.org/lukasss93/telegrambot-php/downloads)](https://packagist.org/packages/lukasss93/telegrambot-php)
[![License](https://poser.pugx.org/lukasss93/telegrambot-php/license)](https://packagist.org/packages/lukasss93/telegrambot-php)

> A very simple PHP [Telegram Bot API](https://core.telegram.org/bots/api) for sending messages. 

Requirements
---------

* PHP 5.6+
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
    //add a script to include the entire folder first!
    use TelegramBot\TelegramBot;
    $telegram = new TelegramBot($token);
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

$telegram = new TelegramBot($token);
$input=$telegram->getWebhookUpdate();
$this->telegram->sendMessage([
    'chat_id' => $input->message->chat->id,
    'text' => 'Hello world!'
]);
```

If you want to get some specific parameter from the Telegram webhook, simply call parameter name in the object:
```php
use TelegramBot\TelegramBot;

$telegram = new TelegramBot($token);
$input=$telegram->getWebhookUpdate();
$text=$input->message->text
```

To upload a Photo or some other files, you need to load it with CurlFile:
```php
// Load a local file to upload. If is already on Telegram's Servers just pass the resource id
$img = curl_file_create('test.png','image/png');
$telegram->sendPhoto([
    'chat_id' => $chat_id, 
    'photo' => $img
]);
```

To download a file on the Telegram's servers
```php
$file = $telegram->getFile($file_id);
$telegram->downloadFile($file->file_path, "./my_downloaded_file_on_local_server.png");
```

If you want to use getUpdates instead of the WebHook you need a for cycle.
```php
$updates=$telegram->getUpdated();
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
    //$input->message->text => '/test@ExampleBot my args'
    $command=$input->message->getCommand();
    //$command => '/text'
    ```
* getArgs(bool $asString=false)

    ```php
    //$input->message->text => '/test@ExampleBot my args'
    $args_array=$input->message->getArgs();
    //$args_array[0] => 'my'
    //$args_array[1] => 'args'
    $args_string=$input->message->getArgs(true);
    //$args_string => 'my args'
    ```


Build keyboard parameters
------------
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