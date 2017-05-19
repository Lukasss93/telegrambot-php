<?php

namespace TelegramBot\Types;

/** This object represents a videonote. */
class VideoNote
{
    /** @var string Unique identifier for this file */
    public $file_id;

    /** @var int Video width as defined by sender */
    public $length;

    /** @var int Duration of the video in seconds as defined by sender */
    public $duration;

    /** @var PhotoSize Optional. Video thumbnail */
    public $thumb;

    /** @var int Optional. File size */
    public $file_size;
}