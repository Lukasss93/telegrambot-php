<?php

namespace TelegramBot\Enums;

class MessageEntityTypes extends Enum
{
    public const MENTION = 'mention';
    public const HASHTAG = 'hashtag';
    public const CASHTAG = 'cashtag';
    public const BOT_COMMAND = 'bot_command';
    public const URL = 'url';
    public const EMAIL = 'email';
    public const PHONE_NUMBER = 'phone_number';
    public const BOLD = 'bold';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const STRIKETHROUGH = 'strikethrough';
    public const CODE = 'code';
    public const PRE = 'pre';
    public const TEXT_LINK = 'text_link';
    public const TEXT_MENTION = 'text_mention';
}
