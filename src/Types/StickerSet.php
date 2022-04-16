<?php

namespace TelegramBot\Types;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#stickerset
 */
class StickerSet
{
    /**
     * Sticker set name
     * @var string $name
     */
    public $name;

    /**
     * Sticker set title
     * @var string $title
     */
    public $title;

    /**
     * True, if the sticker is animated
     * @var bool $is_animated
     */
    public $is_animated;

    /**
     * True, if the sticker set contains {@see https://telegram.org/blog/video-stickers-better-reactions video stickers}
     * @var bool $is_video
     */
    public $is_video;

    /**
     * True, if the sticker set contains masks
     * @var bool $contains_masks
     */
    public $contains_masks;

    /**
     * List of all set stickers
     * @var Sticker[] $stickers
     */
    public $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS, or .WEBM format
     * @var PhotoSize $thumb
     */
    public $thumb;
}
