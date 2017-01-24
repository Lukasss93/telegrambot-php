<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound) stored on the Telegram servers.
 * By default, this animated MPEG-4 file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the animation.
 */
class InlineQueryResultCachedMpeg4Gif
{
    /** @var string Type of the result, must be mpeg4_gif */
    public $type;

    /** @var string Unique identifier for this result, 1-64 bytes */
    public $id;

    /** @var string A valid file identifier for the MP4 file */
    public $mpeg4_file_id;

    /** @var string Optional. Title for the result */
    public $title;

    /** @var string Optional. Caption of the MPEG-4 file to be sent, 0-200 characters */
    public $caption;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the video animation */
    public $input_message_content;
}