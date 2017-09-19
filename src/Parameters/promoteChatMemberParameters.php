<?php

namespace TelegramBot\Parameters;

class promoteChatMemberParameters extends BaseParameter
{
	private $chat_id;
	private $user_id;
	private $can_change_info;
	private $can_post_messages;
	private $can_edit_messages;
	private $can_delete_messages;
	private $can_invite_users;
	private $can_restrict_members;
	private $can_pin_messages;
	private $can_promote_members;

	private function __construct(){}

	public static function init()
	{
		return new promoteChatMemberParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the target group or username of the target supergroup or channel (in the format [at]channelusername)
	 * @param int|string $value
	 * @return $this
	 */
	public function chat_id($value)
	{
		$this->chat_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Unique identifier of the target user
	 * @param int $value
	 * @return $this
	 */
	public function user_id($value)
	{
		$this->user_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can change chat title, photo and other settings
	 * @param bool $value
	 * @return $this
	 */
	public function can_change_info($value)
	{
		$this->can_change_info=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can create channel posts, channels only
	 * @param bool $value
	 * @return $this
	 */
	public function can_post_messages($value)
	{
		$this->can_post_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can edit messages of other users, channels only
	 * @param bool $value
	 * @return $this
	 */
	public function can_edit_messages($value)
	{
		$this->can_edit_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can delete messages of other users
	 * @param bool $value
	 * @return $this
	 */
	public function can_delete_messages($value)
	{
		$this->can_delete_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can invite new users to the chat
	 * @param bool $value
	 * @return $this
	 */
	public function can_invite_users($value)
	{
		$this->can_invite_users=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can restrict, ban or unban chat members
	 * @param bool $value
	 * @return $this
	 */
	public function can_restrict_members($value)
	{
		$this->can_restrict_members=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can pin messages, supergroups only
	 * @param bool $value
	 * @return $this
	 */
	public function can_pin_messages($value)
	{
		$this->can_pin_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the administrator can add new administrators with a subset of his own privileges or
	 * demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by him)
	 * @param bool $value
	 * @return $this
	 */
	public function can_promote_members($value)
	{
		$this->can_promote_members=$value;
		return $this;
	}

}