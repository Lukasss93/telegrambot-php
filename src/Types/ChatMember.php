<?php

namespace TelegramBot\Types;

/** This object contains information about one member of the chat. */
class ChatMember
{
    /** @var User Information about the user */
    public $user;

    /** @var string The member's status in the chat. Can be “creator”, “administrator”, “member”, “left” or “kicked” */
    public $status;
}