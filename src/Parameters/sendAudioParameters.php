<?php

namespace TelegramBot\Parameters;

class sendAudioParameters extends BaseSendParameter
{
	private $audio;
	private $caption;
	private $duration;
	private $performer;
	private $title;

	private function __construct(){}

	public static function init()
	{
		return new sendAudioParameters();
	}

	/**
	 * REQUIRED - Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get an audio file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function audio($value)
	{
		$this->audio=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Audio caption, 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Duration of the audio in seconds
	 * @param int $value
	 * @return $this
	 */
	public function duration($value)
	{
		$this->duration=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Performer
	 * @param string $value
	 * @return $this
	 */
	public function performer($value)
	{
		$this->performer=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Track name
	 * @param string $value
	 * @return $this
	 */
	public function title($value)
	{
		$this->title=$value;
		return $this;
	}
}