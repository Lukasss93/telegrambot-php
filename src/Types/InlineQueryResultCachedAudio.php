<?php

namespace TelegramBot\Types;

/**
 * Represents a link to an mp3 audio file stored on the Telegram servers.
 * By default, this audio file will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the audio.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InlineQueryResultCachedAudio
{
    /** @var string Type of the result, must be audio */
    public $type;

    /** @var string Unique identifier for this result, 1-64 bytes */
    public $id;

    /** @var string A valid file identifier for the audio file */
    public $audio_file_id;

    /** @var string Optional. Caption, 0-200 characters */
    public $caption;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the audio */
    public $input_message_content;
}