<?php

namespace TelegramBot\Types;

/** This object represents one size of a photo or a File / Sticker thumbnail. */
class PhotoSize
{
    /** @var string Unique identifier for this file */
    public $file_id;

    /** @var int Photo width */
    public $width;

    /** @var int Photo height */
    public $height;

    /** @var int Optional. File size */
    public $file_size;
}