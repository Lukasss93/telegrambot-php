<?php

namespace TelegramBot\Parameters;

class sendPhotoParameters extends BaseSendParameter
{
	private $photo;
	private $caption;

	private function __construct(){}

	public static function init()
	{
		return new sendPhotoParameters();
	}

	/**
	 * REQUIRED - Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function photo($value)
	{
		$this->photo=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Photo caption (may also be used when resending photos by file_id), 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}
}