<?php

namespace TelegramBot\Types;

/**
 * Represents a venue. By default, the venue will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the venue.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InlineQueryResultVenue {
	/** @var string Type of the result, must be venue */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 Bytes */
	public $id;
	
	/** @var double Latitude of the venue location in degrees */
	public $latitude;
	
	/** @var double Longitude of the venue location in degrees */
	public $longitude;
	
	/** @var string Title of the venue */
	public $title;
	
	/** @var string Address of the venue */
	public $address;
	
	/** @var string Optional. Foursquare identifier of the venue if known */
	public $foursquare_id;
	
	/** @var string $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.) */
	public $foursquare_type;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the venue */
	public $input_message_content;
	
	/** @var string Optional. Url of the thumbnail for the result */
	public $thumb_url;
	
	/** @var int Optional. Thumbnail width */
	public $thumb_width;
	
	/** @var int Optional. Thumbnail height */
	public $thumb_height;
}
