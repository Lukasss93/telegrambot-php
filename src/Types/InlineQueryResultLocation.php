<?php

namespace TelegramBot\Types;

/**
 * Represents a location on a map. By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the location.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation
{
    /**
     * Type of the result, must be location
     * @var string $type
     */
    public $type;
    
    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string $id
     */
    public $id;
    
    /**
     * Location latitude in degrees
     * @var double $latitude
     */
    public $latitude;
    
    /**
     * Location longitude in degrees
     * @var double $longitude
     */
    public $longitude;
    
    /**
     * Location title
     * @var string $title
     */
    public $title;
    
    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     * @var int $live_period
     */
    public $live_period;
    
    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;
    
    /**
     * Optional. Content of the message to be sent instead of the location
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;
    
    /**
     * Optional. Url of the thumbnail for the result
     * @var string $thumb_url
     */
    public $thumb_url;
    
    /**
     * Optional. Thumbnail width
     * @var int $thumb_width
     */
    public $thumb_width;
    
    /**
     * Optional. Thumbnail height
     * @var int $thumb_height
     */
    public $thumb_height;
}
