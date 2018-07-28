<?php

namespace TelegramBot\Types;

/**
 * Represents an issue with the front side of a document. The error is considered resolved when the file with the front
 * side of the document changes.
 * Class PassportElementErrorFrontSide
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportelementerrorfrontside
 */
class PassportElementErrorFrontSide {
	
	/**
	 * @var string $source Error source, must be front_side
	 */
	public $source;
	
	/**
	 * @var string $type The section of the user's Telegram Passport which has the error, one of “personal_details”,
	 *     “passport”, “driver_license”, “identity_card”, “internal_passport”
	 */
	public $type;
	
	/**
	 * @var string $file_hash Base64-encoded hash of the file with the front side of the document
	 */
	public $file_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
