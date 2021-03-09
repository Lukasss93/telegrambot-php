<?php

namespace TelegramBot\Types;

/**
 * This object represents a service message about a voice chat ended in the chat.
 * @see https://core.telegram.org/bots/api#voicechatended
 */
class VoiceChatEnded
{
    /**
     * Voice chat duration; in seconds
     * @var int $duration
     */
    public $duration;
}
