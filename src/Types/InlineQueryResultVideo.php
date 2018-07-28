<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a page containing an embedded video player or a video file.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the video. */
class InlineQueryResultVideo {
	/** @var string Type of the result, must be video */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 bytes */
	public $id;
	
	/** @var string A valid URL for the embedded video player or video file */
	public $video_url;
	
	/** @var string Mime type of the content of video url, “text/html” or “video/mp4” */
	public $mime_type;
	
	/** @var string URL of the thumbnail (jpeg only) for the video */
	public $thumb_url;
	
	/** @var string Title for the result */
	public $title;
	
	/** @var string Optional. Caption of the video to be sent, 0-200 characters */
	public $caption;
	
	/** @var int Optional. Video width */
	public $video_width;
	
	/** @var int Optional. Video height */
	public $video_height;
	
	/** @var int Optional. Video duration in seconds */
	public $video_duration;
	
	/** @var string Optional. Short description of the result */
	public $description;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the video */
	public $input_message_content;
}
