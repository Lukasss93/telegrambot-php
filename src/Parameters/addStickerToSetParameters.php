<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\MaskPosition;

class addStickerToSetParameters extends BaseParameter
{
	private $user_id;
	private $name;
	private $png_sticker;
	private $emojis;
	private $mask_position;

	private function __construct(){}

	public static function init()
	{
		return new addStickerToSetParameters();
	}

	/**
	 * REQUIRED - User identifier of sticker file owner
	 * @param int $value
	 * @return $this
	 */
	public function user_id($value)
	{
		$this->user_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Sticker set name
	 * @param string $value
	 * @return $this
	 */
	public function name($value)
	{
		$this->name=$value;
		return $this;
	}

	/**
	 * REQUIRED - Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px,
	 * and either width or height must be exactly 512px. Pass a file_id as a String to send a file that already exists
	 * on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet,
	 * or upload a new one using multipart/form-data. More info on Sending Files »
	 * @param string $value File path
	 * @return $this
	 */
	public function png_sticker($value)
	{
		$this->png_sticker=$value;
		return $this;
	}

	/**
	 * REQUIRED - One or more emoji corresponding to the sticker
	 * @param string $value
	 * @return $this
	 */
	public function emojis($value)
	{
		$this->emojis=$value;
		return $this;
	}

	/**
	 * OPTIONAL - An object for position where the mask should be placed on faces
	 * @param MaskPosition $value
	 * @return $this
	 */
	public function mask_position($value)
	{
		$this->mask_position=json_encode($value);
		return $this;
	}

}