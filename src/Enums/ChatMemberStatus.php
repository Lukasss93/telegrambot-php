<?php

namespace TelegramBot\Enums;

class ChatMemberStatus extends Enum
{
    public const CREATOR = 'creator';
    public const ADMINISTRATOR = 'administrator';
    public const MEMBER = 'member';
    public const RESTRICTED = 'restricted';
    public const LEFT = 'left';
    public const KICKED = 'kicked';
}
