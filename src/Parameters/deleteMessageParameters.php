<?php

namespace TelegramBot\Parameters;

class deleteMessageParameters extends BaseParameter
{
	private $chat_id;
	private $message_id;

	private function __construct(){}

	public static function init()
	{
		return new deleteMessageParameters();
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
	 * REQUIRED - Identifier of the message to delete
	 * @param int $value
	 * @return $this
	 */
	public function message_id($value)
	{
		$this->message_id=$value;
		return $this;
	}

}