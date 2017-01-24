<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a file. By default, this file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the file.
 * Currently, only .PDF and .ZIP files can be sent using this method.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InlineQueryResultDocument
{
    /** @var string Type of the result, must be document */
    public $type;

    /** @var string Unique identifier for this result, 1-64 bytes */
    public $id;

    /** @var string Title for the result */
    public $title;

    /** @var string Optional. Caption of the document to be sent, 0-200 characters */
    public $caption;

    /** @var string A valid URL for the file */
    public $document_url;

    /** @var string Mime type of the content of the file, either “application/pdf” or “application/zip” */
    public $mime_type;

    /** @var string Optional. Short description of the result */
    public $description;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the file */
    public $input_message_content;

    /** @var string Optional. URL of the thumbnail (jpeg only) for the file */
    public $thumb_url;

    /** @var int Optional. Thumbnail width */
    public $thumb_width;

    /** @var int Optional. Thumbnail height */
    public $thumb_height;
}