<?php
/**
 * Created by PhpStorm.
 * User: LucaFisso
 * Date: 10/08/2017
 * Time: 17:19
 */

namespace TelegramBot\Parameters;

use TelegramBot\Types\InlineKeyboardMarkup;

abstract class BaseEditParameter extends BaseParameter
{
	private $chat_id;
	private $message_id;
	private $inline_message_id;
	private $reply_markup;

	/**
	 * OPTIONAL - Unique identifier for the target chat or username of the target channel (in the format [at]channelusername)
	 * @param int|string $value
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

	/**
	 * OPTIONAL - An object for an inline keyboard.
	 * @param InlineKeyboardMarkup $value
	 * @return $this
	 */
	public function reply_markup($value)
	{
		$this->reply_markup=json_encode($value);
		return $this;
	}
}