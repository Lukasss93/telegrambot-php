<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound).
 * By default, this animated MPEG-4 file will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the animation. */
class InlineQueryResultMpeg4Gif {
	/** @var string Type of the result, must be mpeg4_gif */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 bytes */
	public $id;
	
	/** @var string A valid URL for the MP4 file. File size must not exceed 1MB */
	public $mpeg4_url;
	
	/** @var int Optional. Video width */
	public $mpeg4_width;
	
	/** @var int Optional. Video height */
	public $mpeg4_height;
	
	/** @var int Optional. Video duration */
	public $mpeg4_duration;
	
	/** @var string URL of the static thumbnail (jpeg or gif) for the result */
	public $thumb_url;
	
	/** @var string Optional. Title for the result */
	public $title;
	
	/** @var string Optional. Caption of the MPEG-4 file to be sent, 0-200 characters */
	public $caption;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the video animation */
	public $input_message_content;
}
