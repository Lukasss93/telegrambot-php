<?php

namespace TelegramBot\Types;

/**
 * Represents a link to an animated GIF file.
 * By default, this animated GIF file will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with
 * the specified content instead of the animation.
 */
class InlineQueryResultGif
{
    /** @var string Type of the result, must be gif */
    public $type;

    /** @var string Unique identifier for this result, 1-64 bytes */
    public $id;

    /** @var string A valid URL for the GIF file. File size must not exceed 1MB */
    public $gif_url;

    /** @var int Optional. Width of the GIF */
    public $gif_width;

    /** @var int Optional. Height of the GIF */
    public $gif_height;
    
    /** @var int Optional. Duration of the GIF */
    public $gif_duration;

    /** @var string URL of the static thumbnail for the result (jpeg or gif) */
    public $thumb_url;

    /** @var string Optional. Title for the result */
    public $title;

    /** @var string Optional. Caption of the GIF file to be sent, 0-200 characters */
    public $caption;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the GIF animation */
    public $input_message_content;
}