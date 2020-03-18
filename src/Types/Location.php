<?php

namespace TelegramBot\Types;

/**
 * This object represents a point on the map.
 * @see https://core.telegram.org/bots/api#location
 */
class Location
{
    /**
     * Longitude as defined by sender
     * @var double $longitude
     */
    public $longitude;
    
    /**
     * Latitude as defined by sender
     * @var double $latitude
     */
    public $latitude;
}
