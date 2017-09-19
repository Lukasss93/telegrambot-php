<?php

namespace TelegramBot\Parameters;

class sendVoiceParameters extends BaseSendParameter
{
	private $voice;
	private $caption;
	private $duration;

	private function __construct(){}

	public static function init()
	{
		return new sendVoiceParameters();
	}

	/**
	 * REQUIRED - Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get an audio file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function voice($value)
	{
		$this->voice=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Voice message caption, 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Duration of the voice message in seconds
	 * @param int $value
	 * @return $this
	 */
	public function duration($value)
	{
		$this->duration=$value;
		return $this;
	}
}