<?php

namespace TelegramBot\Types;

/**
 * This object represents a service message about a voice chat scheduled in the chat.
 * @see https://core.telegram.org/bots/api#voicechatscheduled
 */
class VideoChatScheduled
{
    /**
     * Point in time (Unix timestamp) when the voice chat is supposed to be started by a chat administrator
     * @var int $start_date
     */
    public $start_date;
}
