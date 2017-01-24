<?php

namespace TelegramBot\Types;

/**
 * This object represents an incoming inline query.
 * When the user sends an empty query, your bot could return some default or trending results.
 */
class InlineQuery
{
    /** @var string Unique identifier for this query */
    public $id;

    /** @var User Sender */
    public $from;

    /** @var Location Optional. Sender location, only for bots that request user location */
    public $location;

    /** @var string Text of the query (up to 512 characters) */
    public $query;

    /** @var string Offset of the results to be returned, can be controlled by the bot */
    public $offset;
}