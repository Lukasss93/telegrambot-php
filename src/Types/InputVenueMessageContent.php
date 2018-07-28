<?php

namespace TelegramBot\Types;

/**
 * Represents the content of a venue message to be sent as the result of an inline query.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InputVenueMessageContent {
	/** @var double Latitude of the venue in degrees */
	public $latitude;
	
	/** @var double Longitude of the venue in degrees */
	public $longitude;
	
	/** @var string Name of the venue */
	public $title;
	
	/** @var string Address of the venue */
	public $address;
	
	/** @var string Optional. Foursquare identifier of the venue, if known */
	public $foursquare_id;
	
	/** @var string $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.) */
	public $foursquare_type;
}
