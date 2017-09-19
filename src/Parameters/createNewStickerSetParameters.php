<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\MaskPosition;

class createNewStickerSetParameters extends BaseParameter
{
	private $user_id;
	private $name;
	private $title;
	private $png_sticker;
	private $emojis;
	private $contains_masks;
	private $mask_position;

	private function __construct(){}

	public static function init()
	{
		return new createNewStickerSetParameters();
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
	 * REQUIRED - Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals).
	 * Can contain only english letters, digits and underscores.
	 * Must begin with a letter, can't contain consecutive underscores and must end
	 * in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
	 * @param string $value
	 * @return $this
	 */
	public function name($value)
	{
		$this->name=$value;
		return $this;
	}

	/**
	 * REQUIRED - Sticker set title, 1-64 characters
	 * @param string $value
	 * @return $this
	 */
	public function title($value)
	{
		$this->title=$value;
		return $this;
	}

	/**
	 * REQUIRED - Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px,
	 * and either width or height must be exactly 512px. More info on Sending Files »
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
	 * OPTIONAL - Pass True, if a set of mask stickers should be created
	 * @param bool $value
	 * @return $this
	 */
	public function contains_masks($value)
	{
		$this->contains_masks=$value;
		return $this;
	}

	/**
	 * REQUIRED - An object for position where the mask should be placed on faces
	 * @param MaskPosition $value
	 * @return $this
	 */
	public function mask_position($value)
	{
		$this->mask_position=json_encode($value);
		return $this;
	}

}