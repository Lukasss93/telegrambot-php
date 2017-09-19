<?php

namespace TelegramBot\Parameters;

class setStickerPositionInSetParameters extends BaseParameter
{
	private $sticker;
	private $position;

	private function __construct(){}

	public static function init()
	{
		return new setStickerPositionInSetParameters();
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

	/**
	 * REQUIRED - New sticker position in the set, zero-based
	 * @param int $value
	 * @return $this
	 */
	public function position($value)
	{
		$this->position=$value;
		return $this;
	}

}