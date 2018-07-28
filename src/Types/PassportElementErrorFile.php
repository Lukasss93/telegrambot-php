<?php

namespace TelegramBot\Types;

/**
 * Represents an issue with a document scan. The error is considered resolved when the file with the document scan
 * changes. Class PassportElementErrorFile
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportelementerrorfile
 */
class PassportElementErrorFile {
	
	/**
	 * @var string $source Error source, must be file
	 */
	public $source;
	
	/**
	 * @var string $type The section of the user's Telegram Passport which has the issue, one of “utility_bill”,
	 *     “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
	 */
	public $type;
	
	/**
	 * @var string $file_hash Base64-encoded file hash
	 */
	public $file_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
