<?php

namespace TelegramBot\Types;

/**
 * Represents a link to an animated GIF file stored on the Telegram servers.
 * By default, this animated GIF file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with specified content instead of the animation.
 */
class InlineQueryResultCachedGif
{
    /** @var string Type of the result, must be gif */
    public $type;

    /** @var string Unique identifier for this result, 1-64 bytes */
    public $id;

    /** @var string A valid file identifier for the GIF file */
    public $gif_file_id;

    /** @var string Optional. Title for the result */
    public $title;

    /** @var string Optional. Caption of the GIF file to be sent, 0-200 characters */
    public $caption;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the GIF animation */
    public $input_message_content;
}