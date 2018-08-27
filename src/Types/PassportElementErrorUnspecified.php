<?php

namespace TelegramBot\Types;

/**
 * Represents an issue in an unspecified place. The error is considered resolved when new data is added.
 * @package TelegramBot\Types
 * @link    https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
class PassportElementErrorUnspecified {
	
	/**
	 * @var string $source Error source, must be unspecified
	 */
	public $source;
	
	/**
	 * @var string $type Type of element of the user's Telegram Passport which has the issue
	 */
	public $type;
	
	/**
	 * @var string $element_hash Base64-encoded element hash
	 */
	public $element_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
