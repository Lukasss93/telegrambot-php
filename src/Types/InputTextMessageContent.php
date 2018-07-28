<?php

namespace TelegramBot\Types;

/** Represents the content of a text message to be sent as the result of an inline query.  */
class InputTextMessageContent {
	/** @var string Text of the message to be sent, 1-4096 characters */
	public $message_text;
	
	/** @var string Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message. */
	public $parse_mode;
	
	/** @var string Optional. Disables link previews for links in the sent message */
	public $disable_web_page_preview;
}
