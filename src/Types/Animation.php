<?php

namespace TelegramBot\Types;

/**
 * You can provide an animation for your game so that it looks stylish in chats (check out Lumberjack for an example).
 * This object represents an animation file to be displayed in the message containing a game.
 */
class Animation
{
    /** @var string Unique file identifier */
    public $file_id;

    /** @var PhotoSize Optional. Animation thumbnail as defined by sender */
    public $thumb;

    /** @var string Optional. Original animation filename as defined by sender */
    public $file_name;

    /** @var string Optional. MIME type of the file as defined by sender */
    public $mime_type;

    /** @var int Optional. File size */
    public $file_size;
}