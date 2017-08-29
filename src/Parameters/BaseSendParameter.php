<?php
/**
 * Created by PhpStorm.
 * User: LucaFisso
 * Date: 10/08/2017
 * Time: 17:19
 */

namespace TelegramBot\Parameters;

use TelegramBot\Types\ForceReply;
use TelegramBot\Types\InlineKeyboardMarkup;
use TelegramBot\Types\ReplyKeyboardMarkup;
use TelegramBot\Types\ReplyKeyboardRemove;

abstract class BaseSendParameter extends BaseParameter
{
	private $chat_id;
	private $disable_notification;
	private $reply_to_message_id;
	private $reply_markup;

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
	 * OPTIONAL - Additional interface options. An object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
	 * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $value
	 * @return $this
	 */
	public function reply_markup($value)
	{
		$this->reply_markup=json_encode($value);
		return $this;
	}
}