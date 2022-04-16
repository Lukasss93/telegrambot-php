<?php

namespace TelegramBot\Enums;

use TelegramBot\Types\ChatMemberAdministrator;
use TelegramBot\Types\ChatMemberBanned;
use TelegramBot\Types\ChatMemberLeft;
use TelegramBot\Types\ChatMemberMember;
use TelegramBot\Types\ChatMemberOwner;
use TelegramBot\Types\ChatMemberRestricted;

class ChatMemberType extends Enum
{
    public const OWNER = ChatMemberOwner::class;
    public const ADMINISTRATOR = ChatMemberAdministrator::class;
    public const MEMBER = ChatMemberMember::class;
    public const RESTRICTED = ChatMemberRestricted::class;
    public const LEFT = ChatMemberLeft::class;
    public const BANNED = ChatMemberBanned::class;
}
