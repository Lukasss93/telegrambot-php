<?php

namespace TelegramBot\Types;

/**
 * Represents the content of a location message to be sent as the result of an inline query.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InputLocationMessageContent
{
    /** @var double Latitude of the location in degrees */
    public $latitude;

    /** @var double Longitude of the location in degrees */
    public $longitude;
}