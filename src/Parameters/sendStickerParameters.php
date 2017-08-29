<?php

namespace TelegramBot\Parameters;

class sendStickerParameters extends BaseSendParameter
{
	private $sticker;

	private function __construct(){}

	public static function init()
	{
		return new sendStickerParameters();
	}

	/**
	 * REQUIRED - Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get a .webp file from the Internet, or upload a new one using multipart/form-data.
	 * More info on Sending Files »
	 * @param string $value
	 * @return $this
	 */
	public function sticker($value)
	{
		$this->sticker=$value;
		return $this;
	}

}