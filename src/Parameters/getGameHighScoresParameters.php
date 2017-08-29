<?php

namespace TelegramBot\Parameters;

class getGameHighScoresParameters extends BaseParameter
{
	private $user_id;
	private $chat_id;
	private $message_id;
	private $inline_message_id;

	private function __construct(){}

	public static function init()
	{
		return new getGameHighScoresParameters();
	}

	/**
	 * REQUIRED - Target user id
	 * @param int $value
	 * @return $this
	 */
	public function user_id($value)
	{
		$this->user_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if inline_message_id is not specified. Unique identifier for the target chat
	 * @param int $value
	 * @return $this
	 */
	public function chat_id($value)
	{
		$this->chat_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if inline_message_id is not specified. Identifier of the sent message
	 * @param int $value
	 * @return $this
	 */
	public function message_id($value)
	{
		$this->message_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if chat_id and message_id are not specified. Identifier of the inline message
	 * @param string $value
	 * @return $this
	 */
	public function inline_message_id($value)
	{
		$this->inline_message_id=$value;
		return $this;
	}
}