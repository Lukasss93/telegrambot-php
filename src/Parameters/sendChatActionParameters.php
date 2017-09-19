<?php

namespace TelegramBot\Parameters;

class sendChatActionParameters extends BaseParameter
{
	private $chat_id;
	private $action;

	private function __construct(){}

	public static function init()
	{
		return new sendChatActionParameters();
	}

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
	 * REQUIRED - Type of action to broadcast. Choose one, depending on what the user is about to receive:
	 * typing for text messages, upload_photo for photos, record_video or upload_video for videos,
	 * record_audio or upload_audio for audio files, upload_document for general files,
	 * find_location for location data, record_video_note or upload_video_note for video notes.
	 * @param string $value File path
	 * @return $this
	 */
	public function action($value)
	{
		$this->action=$value;
		return $this;
	}
}