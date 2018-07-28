<?php

namespace TelegramBot\Types;

/**
 * This object represents a file uploaded to Telegram Passport. Currently all Telegram Passport files are in JPEG
 * format when decrypted and don't exceed 10MB. Class PassportFile
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportfile
 */
class PassportFile {
	
	/** @var string $file_id Unique identifier for this file*/
	public $file_id;
	
	/** @var int $file_size File size */
	public $file_size;
	
	/** @var int $file_date Unix time when the file was uploaded */
	public $file_date;
}
