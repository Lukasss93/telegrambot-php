<?php

namespace TelegramBot\Parameters;

class sendVideoParameters extends BaseSendParameter
{
	private $video;
	private $duration;
	private $width;
	private $height;
	private $caption;

	private function __construct(){}

	public static function init()
	{
		return new sendVideoParameters();
	}

	/**
	 * REQUIRED - Video to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get an audio file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function video($value)
	{
		$this->video=$value;
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
	 * OPTIONAL - Video width
	 * @param int $value
	 * @return $this
	 */
	public function width($value)
	{
		$this->width=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Video height
	 * @param int $value
	 * @return $this
	 */
	public function height($value)
	{
		$this->height=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Video caption (may also be used when resending videos by file_id), 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}
}