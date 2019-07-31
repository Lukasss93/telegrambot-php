<?php

namespace TelegramBot\Types;

/**
 * Describes actions that a non-administrator user is allowed to take in a chat.
 * @package TelegramBot\Types
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions {
	
	/** @var bool Optional. True, if the user is allowed to send text messages, contacts, locations and venues */
	public $can_send_messages;
	
	/** @var bool Optional. True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages */
	public $can_send_media_messages;
	
	/** @var bool Optional. True, if the user is allowed to send polls, implies can_send_messages */
	public $can_send_polls;
	
	/** @var bool Optional. True, if the user is allowed to send animations, games, stickers and use inline bots, implies can_send_media_messages */
	public $can_send_other_messages;
	
	/** @var bool Optional. True, if the user is allowed to add web page previews to their messages, implies can_send_media_messages */
	public $can_add_web_page_previews;
	
	/** @var bool Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups */
	public $can_change_info;
	
	/** @var bool Optional. True, if the user is allowed to invite new users to the chat */
	public $can_invite_users;
	
	/** @var bool Optional. True, if the user is allowed to pin messages. Ignored in public supergroups */
	public $can_pin_messages;
}
