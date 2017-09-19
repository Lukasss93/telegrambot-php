<?php

namespace TelegramBot\Parameters;

class forwardMessageParameters extends BaseParameter
{
	private $chat_id;
	private $from_chat_id;
	private $disable_notification;
	private $message_id;

	private function __construct(){}

	public static function init()
	{
		return new forwardMessageParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the target chat or username of the target channel (in the format [at]channelusername)
	 * @param int|string $value
	 * @return $this
	 */
	public function chat_id($value)
	{
		$this->chat_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Unique identifier for the chat where the original message was sent (or channel username in the format [at]channelusername)
	 * @param int|string $value File path
	 * @return $this
	 */
	public function from_chat_id($value)
	{
		$this->from_chat_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Sends the message silently. Users will receive a notification with no sound.
	 * @param bool $value
	 * @return $this
	 */
	public function disable_notification($value)
	{
		$this->disable_notification=$value;
		return $this;
	}

	/**
	 * REQUIRED - Message identifier in the chat specified in from_chat_id
	 * @param int $value
	 * @return $this
	 */
	public function message_id($value)
	{
		$this->message_id=$value;
		return $this;
	}

}