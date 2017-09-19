<?php

namespace TelegramBot\Parameters;

class kickChatMemberParameters extends BaseParameter
{
	private $chat_id;
	private $user_id;
	private $until_date;

	private function __construct(){}

	public static function init()
	{
		return new kickChatMemberParameters();
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
	 * OPTIONAL - Date when the user will be unbanned, unix time. If user is banned for more than 366 days or less than 30 seconds from the current time they are considered to be banned forever
	 * @param int $value
	 * @return $this
	 */
	public function until_date($value)
	{
		$this->until_date=$value;
		return $this;
	}

}