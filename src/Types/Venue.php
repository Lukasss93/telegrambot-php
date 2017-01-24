<?php

namespace TelegramBot\Types;

/** This object represents a venue. */
class Venue
{
    /** @var Location Venue location */
    public $location;

    /** @var string Name of the venue */
    public $title;

    /** @var string Address of the venue */
    public $address;

    /** @var string Optional. Foursquare identifier of the venue */
    public $foursquare_id;
}