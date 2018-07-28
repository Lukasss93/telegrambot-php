<?php

namespace TelegramBot\Types;

/**
 * Represents a link to a voice message stored on the Telegram servers.
 * By default, this voice message will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the voice
 * message. Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore
 * them.
 */
class InlineQueryResultCachedVoice {
	
	/** @var string Type of the result, must be voice */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 bytes */
	public $id;
	
	/** @var string A valid file identifier for the voice message */
	public $voice_file_id;
	
	/** @var string Voice message title */
	public $title;
	
	/** @var string Optional. Caption, 0-200 characters */
	public $caption;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Optional. Content of the message to be sent instead of the voice message */
	public $input_message_content;
}
