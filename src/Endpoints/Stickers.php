<?php

namespace TelegramBot\Endpoints;

use TelegramBot\TelegramBot;
use TelegramBot\Types\File;
use TelegramBot\Types\Message;
use TelegramBot\Types\StickerSet;

/**
 * @mixin TelegramBot
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or
     * {@see https://telegram.org/blog/animated-stickers animated} .TGS stickers.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendsticker
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $sticker Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .webp file from the Internet, or upload a new one using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @param array $clientOpt Client parameters
     * @return Message
     */
    public function sendSticker(int|string $chat_id, mixed $sticker, array $opt = [], array $clientOpt = []): Message
    {
        return $this->sendAttachment($chat_id, __FUNCTION__, 'sticker', $sticker, $opt, $clientOpt);
    }

    /**
     * Use this method to get a sticker set.
     * On success, a {@see https://core.telegram.org/bots/api#stickerset StickerSet} object is returned.
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param string $name Name of the sticker set
     * @return StickerSet
     */
    public function getStickerSet(string $name): StickerSet
    {
        $required = compact('name');
        return $this->requestJson(__FUNCTION__, $required, StickerSet::class);
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet and
     * addStickerToSet methods (can be used multiple times).
     * Returns the uploaded {@see https://core.telegram.org/bots/api#file File} on success.
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param int $user_id User identifier of sticker file owner
     * @param mixed $png_sticker Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $clientOpt Client parameters
     * @return File
     */
    public function uploadStickerFile(int $user_id, mixed $png_sticker, array $clientOpt = []): File
    {
        $required = compact('user_id', 'png_sticker');
        if (is_resource($png_sticker)) {
            return $this->requestMultipart(__FUNCTION__, $required, File::class, $clientOpt);
        }
        return $this->requestJson(__FUNCTION__, $required, File::class);
    }

    /**
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param int $user_id User identifier of created sticker set owner
     * @param string $name Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can contain only english letters, digits and underscores. Must begin with a letter, can't contain consecutive underscores and must end in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
     * @param string $title Sticker set title, 1-64 characters
     * @param string $emojis One or more emoji corresponding to the sticker
     * @param array $opt Optional parameters
     * @param array $clientOpt Client parameters
     * @return bool
     */
    public function createNewStickerSet(int $user_id, string $name, string $title, string $emojis, array $opt = [], array $clientOpt = []): bool
    {
        $required = compact('user_id', 'name', 'title', 'emojis');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), clientOpt: $clientOpt);
    }

    /**
     * Use this method to add a new sticker to a set created by the bot.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Animated stickers can be added to animated sticker sets and only to them.
     * Animated sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers. Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param int $user_id User identifier of sticker set owner
     * @param string $name Sticker set name
     * @param string $emojis One or more emoji corresponding to the sticker
     * @param array $opt Optional parameters
     * @param array $clientOpt Client parameters
     * @return bool
     */
    public function addStickerToSet(int $user_id, string $name, string $emojis, array $opt = [], array $clientOpt = []): bool
    {
        $required = compact('user_id', 'name', 'emojis');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), clientOpt: $clientOpt);
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
     * @return bool
     */
    public function setStickerPositionInSet(string $sticker, int $position): bool
    {
        $required = compact('sticker', 'position');
        return $this->requestJson(__FUNCTION__, $required);
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param string $sticker File identifier of the sticker
     * @return bool
     */
    public function deleteStickerFromSet(string $sticker): bool
    {
        $required = compact('sticker');
        return $this->requestJson(__FUNCTION__, $required);
    }

    /**
     * Use this method to set the thumbnail of a sticker set.
     * Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumb
     * @param string $name Sticker set name
     * @param int $user_id User identifier of the sticker set owner
     * @param array $opt Optional parameters
     * @param array $clientOpt Client parameters
     * @return bool
     */
    public function setStickerSetThumb(string $name, int $user_id, array $opt = [], array $clientOpt = []): bool
    {
        $required = compact('name', 'user_id');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), clientOpt: $clientOpt);
    }
}
