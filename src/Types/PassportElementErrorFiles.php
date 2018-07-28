<?php

namespace TelegramBot\Types;

/**
 * Represents an issue with a list of scans. The error is considered resolved when the list of files containing the
 * scans changes. Class PassportElementErrorFiles
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportelementerrorfiles
 */
class PassportElementErrorFiles {
	
	/**
	 * @var string $source Error source, must be files
	 */
	public $source;
	
	/**
	 * @var string $type The section of the user's Telegram Passport which has the issue, one of “utility_bill”,
	 *     “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
	 */
	public $type;
	
	/**
	 * @var string $file_hash Base64-encoded file hashes
	 */
	public $file_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
