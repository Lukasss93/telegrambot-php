<?php

namespace TelegramBot\Parameters;

class sendDocumentParameters extends BaseSendParameter
{
	private $document;
	private $caption;

	private function __construct(){}

	public static function init()
	{
		return new sendDocumentParameters();
	}

	/**
	 * REQUIRED - File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended),
	 * pass an HTTP URL as a String for Telegram to get a file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function document($value)
	{
		$this->document=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Document caption (may also be used when resending documents by file_id), 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}
}