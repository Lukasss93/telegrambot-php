<?php

namespace TelegramBot\Types;

/**
 * Represents a join request sent to a chat.
 * @see https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest
{

    /**
     * Chat to which the request was sent
     * @var Chat $chat
     */
    public $chat;

    /**
     * User that sent the join request
     * @var User $from
     */
    public $from;

    /**
     * Date the request was sent in Unix time
     * @var int $date
     */
    public $date;

    /**
     * Optional. Bio of the user.
     * @var string $bio
     */
    public $bio;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     * @var ChatInviteLink $invite_link
     */
    public $invite_link;
}
