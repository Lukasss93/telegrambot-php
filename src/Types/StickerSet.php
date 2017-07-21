<?php

namespace TelegramBot\Types;

/** This object represents a sticker. */
class StickerSet
{
    /** @var string Sticker set name */
    public $name;

    /** @var string Sticker set title */
    public $title;

    /** @var bool True, if the sticker set contains masks */
    public $is_masks;

    /** @var Sticker[] List of all set stickers */
    public $stickers;
}