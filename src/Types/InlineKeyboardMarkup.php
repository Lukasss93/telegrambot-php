<?php

namespace TelegramBot\Types;

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will display unsupported
 * message.
 */
class InlineKeyboardMarkup {
	/** @var InlineKeyboardButton[][] Array of button rows, each represented by an Array of InlineKeyboardButton objects */
	public $inline_keyboard;
}
