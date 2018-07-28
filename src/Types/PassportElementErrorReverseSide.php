<?php

namespace TelegramBot\Types;

/**
 * Represents an issue with the reverse side of a document. The error is considered resolved when the file with reverse
 * side of the document changes. Class PassportElementErrorReverseSide
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
class PassportElementErrorReverseSide {
	
	/**
	 * @var string $source Error source, must be reverse_side
	 */
	public $source;
	
	/**
	 * @var string $type The section of the user's Telegram Passport which has the issue, one of “driver_license”,
	 *     “identity_card”
	 */
	public $type;
	
	/**
	 * @var string $file_hash Base64-encoded hash of the file with the reverse side of the document
	 */
	public $file_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
