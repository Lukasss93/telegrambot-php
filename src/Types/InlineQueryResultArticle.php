<?php

namespace TelegramBot\Types;

/** Represents a link to an article or web page. */
class InlineQueryResultArticle {
	/** @var string Type of the result, must be article */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 Bytes */
	public $id;
	
	/** @var string Title of the result */
	public $title;
	
	/** @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent Content of the message to be sent */
	public $input_message_content;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
	
	/** @var string Optional. URL of the result */
	public $url;
	
	/** @var bool Optional. Pass True, if you don't want the URL to be shown in the message */
	public $hide_url;
	
	/** @var string Optional. Short description of the result */
	public $description;
	
	/** @var string Optional. Url of the thumbnail for the result */
	public $thumb_url;
	
	/** @var int Optional. Thumbnail width */
	public $thumb_width;
	
	/** @var int Optional. Thumbnail height */
	public $thumb_height;
}
