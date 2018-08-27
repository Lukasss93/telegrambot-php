<?php

namespace TelegramBot\Types;

/**
 * Represents an issue with one of the files that constitute the translation of a document. The error is considered
 * resolved when the file changes
 * @package TelegramBot\Types
 * @link    https://core.telegram.org/bots/api#passportelementerrortranslationfile
 */
class PassportElementErrorTranslationFile {
	
	/**
	 * @var string $source Error source, must be translation_file
	 */
	public $source;
	
	/**
	 * @var string $type Type of element of the user's Telegram Passport which has the issue, one of “passport”,
	 *      “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”,
	 *      “rental_agreement”, “passport_registration”, “temporary_registration”
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
