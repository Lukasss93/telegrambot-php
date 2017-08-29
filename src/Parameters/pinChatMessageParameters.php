<?php

namespace TelegramBot\Parameters;

class pinChatMessageParameters extends BaseParameter
{
	private $chat_id;
	private $message_id;
	private $disable_notification;

	private function __construct(){}

	public static function init()
	{
		return new pinChatMessageParameters();
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
	 * REQUIRED - Identifier of a message to pin
	 * @param int $value
	 * @return $this
	 */
	public function message_id($value)
	{
		$this->message_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if it is not necessary to send a notification to all group members about the new pinned message
	 * @param bool $value
	 * @return $this
	 */
	public function disable_notification($value)
	{
		$this->disable_notification=$value;
		return $this;
	}
}