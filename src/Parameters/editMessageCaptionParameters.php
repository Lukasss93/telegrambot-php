<?php

namespace TelegramBot\Parameters;

class editMessageCaptionParameters extends BaseEditParameter
{
	private $caption;

	private function __construct(){}

	public static function init()
	{
		return new editMessageCaptionParameters();
	}

	/**
	 * OPTIONAL - New caption of the message
	 * @param string $value
	 * @return $this
	 */
	public function caption($value)
	{
		$this->caption=$value;
		return $this;
	}

}