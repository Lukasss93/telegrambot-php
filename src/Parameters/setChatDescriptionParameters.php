<?php

namespace TelegramBot\Parameters;

class setChatDescriptionParameters extends BaseParameter
{
	private $chat_id;
	private $description;

	private function __construct(){}

	public static function init()
	{
		return new setChatDescriptionParameters();
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
	 * OPTIONAL - New chat description, 0-255 characters
	 * @param string $value
	 * @return $this
	 */
	public function description($value)
	{
		$this->description=$value;
		return $this;
	}
}