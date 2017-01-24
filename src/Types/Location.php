<?php

namespace TelegramBot\Types;

/** This object represents a point on the map. */
class Location
{
    /** @var double Longitude as defined by sender */
    public $longitude;

    /** @var double Latitude as defined by sender */
    public $latitude;
}