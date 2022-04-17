<?php

namespace TelegramBot\Types;

/**
 * This object represents a service message about new members invited to a voice chat.
 * @see https://core.telegram.org/bots/api#voicechatparticipantsinvited
 */
class VideoChatParticipantsInvited
{
    /**
     * Voice chat duration; in seconds
     * @var User[] $users
     */
    public $users;
}
