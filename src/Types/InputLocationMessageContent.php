<?php

namespace TelegramBot\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a location message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputlocationmessagecontent
 */
class InputLocationMessageContent
{
    /**
     * Latitude of the location in degrees
     * @var double $latitude
     */
    public $latitude;
    
    /**
     * Longitude of the location in degrees
     * @var double $longitude
     */
    public $longitude;
    
    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     * @var int $live_period
     */
    public $live_period;
}
