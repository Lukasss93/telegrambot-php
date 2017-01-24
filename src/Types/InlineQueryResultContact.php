<?php

namespace TelegramBot\Types;

/**
 * Represents a contact with a phone number. By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InlineQueryResultContact
{
    /** @var string Type of the result, must be contact */
    public $type;

    /** @var string Unique identifier for this result, 1-64 Bytes */
    public $id;

    /** @var string Contact's phone number */
    public $phone_number;

    /** @var string Contact's first name */
    public $first_name;

    /** @var string Optional. Contact's last name */
    public $last_name;

    /** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
    public $reply_markup;

    /** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the contact */
    public $input_message_content;

    /** @var string Optional. Url of the thumbnail for the result */
    public $thumb_url;

    /** @var int Optional. Thumbnail width */
    public $thumb_width;

    /** @var int Optional. Thumbnail height */
    public $thumb_height;
}