<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a video file stored on the Telegram servers.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the video.
 */
class InlineQueryResultCachedVideo {
	/** @var string Type of the result, must be video */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 bytes */
	public $id;
	
	/** @var string A valid file identifier for the video file */
	public $video_file_id;
	
	/** @var string Title for the result */
	public $title;
	
	/** @var string Optional. Short description of the result */
	public $description;
	
	/** @var string Optional. Caption of the video to be sent, 0-200 characters */
	public $caption;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the video */
	public $input_message_content;
}
