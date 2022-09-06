<?php

namespace TelegramBot\Types;

/**
 * Represents an invite link for a chat.
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink
{
    /**
     * The invite link. If the link was created by another chat administrator,
     * then the second part of the link will be replaced with “…”.
     * @var string $invite_link
     */
    public $invite_link;

    /**
     * Creator of the link
     * @var User $creator
     */
    public $creator;

    /**
     * True, if users joining the chat via the link need to be approved by chat administrators
     * @var bool $creates_join_request
     */
    public $creates_join_request;

    /**
     * True, if the link is primary
     * @var bool $is_primary
     */
    public $is_primary;

    /**
     * True, if the link is revoked
     * @var bool $is_revoked
     */
    public $is_revoked;

    /**
     * Optional. Invite link name
     * @var string $name
     */
    public $name;

    /**
     * Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     * @var int $expire_date
     */
    public $expire_date;

    /**
     * Optional. Maximum number of users that can be members of the chat simultaneously
     * after joining the chat via this invite link; 1-99999
     * @var int $member_limit
     */
    public $member_limit;

    /**
     * Optional. Number of pending join requests created using this link
     * @var int $pending_join_request_count
     */
    public $pending_join_request_count;
}
