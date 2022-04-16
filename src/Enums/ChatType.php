<?php

namespace TelegramBot\Enums;

class ChatType extends Enum
{
    public const PRIVATE = 'private';
    public const GROUP = 'group';
    public const SUPERGROUP = 'supergroup';
    public const CHANNEL = 'channel';
}
