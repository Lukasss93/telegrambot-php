<?php

namespace TelegramBot\Types;

/**
 * Represents a location on a map. By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the location.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InlineQueryResultLocation {
	/** @var string Type of the result, must be location */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 Bytes */
	public $id;
	
	/** @var double Location latitude in degrees */
	public $latitude;
	
	/** @var double Location longitude in degrees */
	public $longitude;
	
	/** @var string Location title */
	public $title;
	
	/** @var int Optional. Period in seconds for which the location can be updated, should be between 60 and 86400. */
	public $live_period;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the location */
	public $input_message_content;
	
	/** @var string Optional. Url of the thumbnail for the result */
	public $thumb_url;
	
	/** @var int Optional. Thumbnail width */
	public $thumb_width;
	
	/** @var int Optional. Thumbnail height */
	public $thumb_height;
}
