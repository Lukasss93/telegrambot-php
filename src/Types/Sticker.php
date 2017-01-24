<?php

namespace TelegramBot\Types;

/** This object represents a sticker. */
class Sticker
{
    /** @var string Unique identifier for this file */
    public $file_id;

    /** @var int Sticker width */
    public $width;

    /** @var int Sticker height */
    public $height;

    /** @var PhotoSize Optional. Sticker thumbnail in .webp or .jpg format */
    public $thumb;

    /** @var string Optional. Emoji associated with the sticker */
    public $emoji;

    /** @var int Optional. File size */
    public $file_size;
}