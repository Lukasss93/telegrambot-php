<?php

namespace TelegramBot\Types;

/**
 * This object represents a game. Use BotFather to create and edit games, their short names will act as unique
 * identifiers.
 */
class Game {
	/** @var string Title of the game */
	public $title;
	
	/** @var string Description of the game */
	public $description;
	
	/** @var PhotoSize[] Photo that will be displayed in the game message in chats. */
	public $photo;
	
	/** @var string Optional. Brief description of the game or high scores included in the game message. Can be automatically edited to include current high scores for the game when the bot calls setGameScore, or manually edited using editMessageText. 0-4096 characters. */
	public $text;
	
	/** @var MessageEntity[] Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc. */
	public $text_entities;
	
	/** @var Animation Optional. Animation that will be displayed in the game message in chats. Upload via BotFather */
	public $animation;
}
