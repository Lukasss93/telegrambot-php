<?php

namespace TelegramBot\Types;

/**
 * Represents a Game.
 * Note: This will only work in Telegram versions released after October 1, 2016.
 * Older clients will not display any inline results if a game result is among them.
 */
class InlineQueryResultGame {
	/** @var string Type of the result, must be game */
	public $type;
	
	/** @var string Unique identifier for this result, 1-64 bytes */
	public $id;
	
	/** @var string Short name of the game */
	public $game_short_name;
	
	/** @var InlineKeyboardMarkup Optional. Inline keyboard attached to the message */
	public $reply_markup;
}
