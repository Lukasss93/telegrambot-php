<?php

namespace TelegramBot\Parameters;

class setGameScoreParameters extends BaseParameter
{
	private $user_id;
	private $score;
	private $force;
	private $disable_edit_message;
	private $chat_id;
	private $message_id;
	private $inline_message_id;

	private function __construct(){}

	public static function init()
	{
		return new setGameScoreParameters();
	}

	/**
	 * REQUIRED - User identifier
	 * @param int $value
	 * @return $this
	 */
	public function user_id($value)
	{
		$this->user_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - New score, must be non-negative
	 * @param int $value
	 * @return $this
	 */
	public function score($value)
	{
		$this->score=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters
	 * @param bool $value
	 * @return $this
	 */
	public function force($value)
	{
		$this->force=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the game message should not be automatically edited to include the current scoreboard
	 * @param bool $value
	 * @return $this
	 */
	public function disable_edit_message($value)
	{
		$this->disable_edit_message=$value;
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