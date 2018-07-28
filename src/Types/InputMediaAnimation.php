<?php

namespace TelegramBot\Types;

/**
 * Represents an animation file (GIF or H.264/MPEG-4 AVC video without sound) to be sent.
 * Class InputMediaAnimation
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#inputmediaanimation
 */
class InputMediaAnimation {
	
	/**
	 * @var string $type Type of the result, must be animation
	 */
	public $type;
	
	/**
	 * @var string $media File to send. Pass a file_id to send a file that exists on the Telegram servers
	 *     (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass
	 *     “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
	 *     More info on Sending Files » (https://core.telegram.org/bots/api#sending-files)
	 */
	public $media;
	
	/**
	 * @var mixed $thumb Optional. Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200
	 *     kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using
	 *     multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass
	 *     “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under
	 *     <file_attach_name>. More info on Sending Files » (https://core.telegram.org/bots/api#sending-files)
	 */
	public $thumb;
	
	/**
	 * @var string $caption Optional. Caption of the animation to be sent, 0-200 characters
	 */
	public $caption;
	
	/**
	 * @var string $parse_mode Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic,
	 *     fixed-width text or inline URLs in the media caption.
	 */
	public $parse_mode;
	
	/**
	 * @var int $width Optional. Animation width
	 */
	public $width;
	
	/**
	 * @var int $height Optional. Animation height
	 */
	public $height;
	
	/**
	 * @var int $duration Optional. Animation duration
	 */
	public $duration;
	
}
