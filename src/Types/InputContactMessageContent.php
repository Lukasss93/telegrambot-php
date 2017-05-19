<?php

namespace TelegramBot\Types;

/**
 * Represents the content of a contact message to be sent as the result of an inline query.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 */
class InputContactMessageContent
{
    /** @var string Contact's phone number */
    public $phone_number;

    /** @var string Contact's first name */
    public $first_name;

    /** @var string Optional. Contact's last name */
    public $last_name;
}