<?php

namespace TelegramBot\Endpoints;

use JsonMapper_Exception;
use TelegramBot\TelegramBot;
use TelegramBot\TelegramException;
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
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendSticker(array $parameters): Message
    {
        $response = $this->endpoint('sendSticker', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to get a sticker set.
     * On success, a {@see https://core.telegram.org/bots/api#stickerset StickerSet} object is returned.
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param string $name Short name of the sticker set that is used in t.me/addstickers/ URLs (e.g., animals)
     * @return StickerSet
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getStickerSet(string $name): StickerSet
    {
        $response = $this->endpoint('getStickerSet', ['name' => $name]);

        /** @var StickerSet $object */
        $object = $this->mapper->map($response->result, new StickerSet());

        return $object;
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet and
     * addStickerToSet methods (can be used multiple times).
     * Returns the uploaded {@see https://core.telegram.org/bots/api#file File} on success.
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param int $user_id User identifier of sticker file owner
     * @param mixed $png_sticker [InputFile] Png image with the sticker, must be up to 512 kilobytes in size,
     *     dimensions must not exceed 512px, and either width or height must be exactly 512px.
     * @return File
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function uploadStickerFile(int $user_id, mixed $png_sticker): File
    {
        $response = $this->endpoint('uploadStickerFile', ['user_id' => $user_id, 'png_sticker' => $png_sticker]);

        /** @var File $object */
        $object = $this->mapper->map($response->result, new File());

        return $object;
    }

    /**
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param array $parameters Parameters
     * @return bool
     * @throws TelegramException
     */
    public function createNewStickerSet(array $parameters): bool
    {
        $response = $this->endpoint('createNewStickerSet', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to add a new sticker to a set created by the bot.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Animated stickers can be added to animated sticker sets and only to them.
     * Animated sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers. Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param array $parameters Parameters
     * @return bool
     * @throws TelegramException
     */
    public function addStickerToSet(array $parameters): bool
    {
        $response = $this->endpoint('addStickerToSet', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
     * @return bool
     * @throws TelegramException
     */
    public function setStickerPositionInSet(string $sticker, int $position): bool
    {
        $response = $this->endpoint('setStickerPositionInSet', ['sticker' => $sticker, 'position' => $position]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param string $sticker File identifier of the sticker
     * @return bool
     * @throws TelegramException
     */
    public function deleteStickerFromSet(string $sticker): bool
    {
        $response = $this->endpoint('deleteStickerFromSet', ['sticker' => $sticker]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set the thumbnail of a sticker set.
     * Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumb
     * @param array $parameters Method parameters
     * @return bool
     * @throws TelegramException
     */
    public function setStickerSetThumb(array $parameters): bool
    {
        $response = $this->endpoint('setStickerSetThumb', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }
}
