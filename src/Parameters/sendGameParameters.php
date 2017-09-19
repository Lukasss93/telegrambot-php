<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\InlineKeyboardMarkup;

class sendGameParameters extends BaseParameter
{
	private $chat_id;
	private $game_short_name;
	private $disable_notification;
	private $reply_to_message_id;
	private $reply_markup;

	private function __construct(){}

	public static function init()
	{
		return new sendGameParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the target chat
	 * @param int $value
	 * @return $this
	 */
	public function chat_id($value)
	{
		$this->chat_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Short name of the game, serves as the unique identifier for the game. Set up your games via Botfather.
	 * @param string $value
	 * @return $this
	 */
	public function game_short_name($value)
	{
		$this->game_short_name=$value;
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
	 * OPTIONAL - If the message is a reply, ID of the original message
	 * @param int $value
	 * @return $this
	 */
	public function reply_to_message_id($value)
	{
		$this->reply_to_message_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - An object for an inline keyboard. If empty, one ‘Play game_title’ button will be shown. If not empty, the first button must launch the game.
	 * @param InlineKeyboardMarkup $value
	 * @return $this
	 */
	public function reply_markup($value)
	{
		$this->reply_markup=json_encode($value);
		return $this;
	}
}