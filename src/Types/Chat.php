<?php

namespace TelegramBot\Types;

/** This object represents a chat. */
class Chat
{
    /** @var int Unique identifier for this chat. This number may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier. */
    public $id;

    /** @var string Type of chat, can be either “private”, “group”, “supergroup” or “channel” */
    public $type;

    /** @var string Optional. Title, for supergroups, channels and group chats */
    public $title;

    /** @var string Optional. Username, for private chats, supergroups and channels if available */
    public $username;

    /** @var string Optional. First name of the other party in a private chat */
    public $first_name;

    /** @var string Optional. Last name of the other party in a private chat */
    public $last_name;

    /** @var bool Optional. True if a group has ‘All Members Are Admins’ enabled */
    public $all_members_are_administrators;
}