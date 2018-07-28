<?php

namespace TelegramBot\Types;

/**
 * This object represents an incoming callback query from a callback button in an inline keyboard.
 * If the button that originated the query was attached to a message sent by the bot, the field message will be
 * present.
 * If the button was attached to a message sent via the bot (in inline mode), the field inline_message_id will be
 * present. Exactly one of the fields data or game_short_name will be present.
 *
 * NOTE: After the user presses an inline button, Telegram clients will display a progress bar until you
 * call answerCallbackQuery. It is, therefore, necessary to react by calling answerCallbackQuery even if
 * no notification to the user is needed (e.g., without specifying any of the optional parameters).
 */
class CallbackQuery {
	/** @var string Unique identifier for this query */
	public $id;
	
	/** @var User Sender */
	public $from;
	
	/** @var Message Optional. Message with the callback button that originated the query. Note that message content and message date will not be available if the message is too old */
	public $message;
	
	/** @var string Optional. Identifier of the message sent via the bot in inline mode, that originated the query. */
	public $inline_message_id;
	
	/** @var string Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games. */
	public $chat_instance;
	
	/** @var string Optional. Data associated with the callback button. Be aware that a bad client can send arbitrary data in this field. */
	public $data;
	
	/** @var string Optional. Short name of a Game to be returned, serves as the unique identifier for the game */
	public $game_short_name;
}
