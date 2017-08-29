<?php

namespace TelegramBot\Parameters;

class sendVideoNoteParameters extends BaseSendParameter
{
	private $video_note;
	private $duration;
	private $length;

	private function __construct(){}

	public static function init()
	{
		return new sendVideoNoteParameters();
	}

	/**
	 * REQUIRED - Video note to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get an audio file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function video_note($value)
	{
		$this->video_note=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Duration of sent video in seconds
	 * @param int $value
	 * @return $this
	 */
	public function duration($value)
	{
		$this->duration=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Video width and height
	 * @param int $value
	 * @return $this
	 */
	public function length($value)
	{
		$this->length=$value;
		return $this;
	}
}