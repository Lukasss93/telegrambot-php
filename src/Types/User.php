<?php

namespace TelegramBot\Types;

/** This object represents a Telegram user or bot. */
class User
{
    /** @var int Unique identifier for this user or bot */
    public $id;

    /** @var string User‘s or bot’s first name */
    public $first_name;

    /** @var string Optional. User‘s or bot’s last name */
    public $last_name;

    /** @var string Optional. User‘s or bot’s username */
    public $username;
    
    /** @var string Optional. IETF language tag of the user's language */
    public $language_code;
}