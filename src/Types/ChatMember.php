<?php

namespace TelegramBot\Types;

/** This object contains information about one member of the chat. */
class ChatMember {
	/** @var User Information about the user */
	public $user;
	
	/** @var string The member's status in the chat. Can be “creator”, “administrator”, “member”, “left” or “kicked” */
	public $status;
	
	/** @var int Optional. Restricted and kicked only. Date when restrictions will be lifted for this user, unix time */
	public $until_date;
	
	/** @var bool Optional. Administrators only. True, if the bot is allowed to edit administrator privileges of that user */
	public $can_be_edited;
	
	/** @var bool Optional. Administrators only. True, if the administrator can change the chat title, photo and other settings */
	public $can_change_info;
	
	/** @var bool Optional. Administrators only. True, if the administrator can post in the channel, channels only */
	public $can_post_messages;
	
	/** @var bool Optional. Administrators only. True, if the administrator can edit messages of other users, channels only */
	public $can_edit_messages;
	
	/** @var bool Optional. Administrators only. True, if the administrator can delete messages of other users */
	public $can_delete_messages;
	
	/** @var bool Optional. Administrators only. True, if the administrator can invite new users to the chat */
	public $can_invite_users;
	
	/** @var bool Optional. Administrators only. True, if the administrator can restrict, ban or unban chat members */
	public $can_restrict_members;
	
	/** @var bool Optional. Administrators only. True, if the administrator can pin messages, supergroups only */
	public $can_pin_messages;
	
	/** @var bool Optional. Administrators only. True, if the administrator can add new administrators with a subset of his own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by the user) */
	public $can_promote_members;
	
	/** @var bool Optional. Restricted only. True, if the user is a member of the chat at the moment of the request */
	public $is_member;

	/** @var bool Optional. Restricted only. True, if the user can send text messages, contacts, locations and venues */
	public $can_send_messages;
	
	/** @var bool Optional. Restricted only. True, if the user can send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages */
	public $can_send_media_messages;
	
	/** @var bool Optional. Restricted only. True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages */
	public $can_send_other_messages;
	
	/** @var bool Optional. Restricted only. True, if user may add web page previews to his messages, implies can_send_media_messages */
	public $can_add_web_page_previews;
}
