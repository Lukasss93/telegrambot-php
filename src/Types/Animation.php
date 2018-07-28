<?php

namespace TelegramBot\Types;

/**
 * This object represents an animation file (GIF or H.264/MPEG-4 AVC video without sound).
 * Class Animation
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#animation
 */
class Animation {
	/** @var string Unique file identifier */
	public $file_id;
	
	/** @var int $width Video width as defined by sender */
	public $width;
	
	/** @var int $height Video height as defined by sender */
	public $height;
	
	/** @var int $duration Duration of the video in seconds as defined by sender */
	public $duration;
	
	/** @var PhotoSize Optional. Animation thumbnail as defined by sender */
	public $thumb;
	
	/** @var string Optional. Original animation filename as defined by sender */
	public $file_name;
	
	/** @var string Optional. MIME type of the file as defined by sender */
	public $mime_type;
	
	/** @var int Optional. File size */
	public $file_size;
}
