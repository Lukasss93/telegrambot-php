<?php

namespace TelegramBot\Types;

/**
 * This object represents a venue.
 * Class Venue
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#venue
 */
class Venue {
	/** @var Location $location Venue location */
	public $location;
	
	/** @var string $title Name of the venue */
	public $title;
	
	/** @var string $address Address of the venue */
	public $address;
	
	/** @var string $foursquare_id Optional. Foursquare identifier of the venue */
	public $foursquare_id;
	
	/** @var string $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.) */
	public $foursquare_type;
}
