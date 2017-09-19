<?php

namespace TelegramBot\Parameters;

class deleteStickerFromSetParameters extends BaseParameter
{
	private $sticker;

	private function __construct(){}

	public static function init()
	{
		return new deleteStickerFromSetParameters();
	}

	/**
	 * REQUIRED - File identifier of the sticker
	 * @param string $value
	 * @return $this
	 */
	public function sticker($value)
	{
		$this->sticker=$value;
		return $this;
	}

}