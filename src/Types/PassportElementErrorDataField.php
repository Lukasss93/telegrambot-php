<?php

namespace TelegramBot\Types;

/**
 * Represents an issue in one of the data fields that was provided by the user. The error is considered resolved when
 * the field's value changes. Class PassportElementErrorDataField
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportelementerrordatafield
 */
class PassportElementErrorDataField {
	
	/**
	 * @var string $source Error source, must be data
	 */
	public $source;
	
	/**
	 * @var string $type The section of the user's Telegram Passport which has the error, one of “personal_details”,
	 *     “passport”, “driver_license”, “identity_card”, “internal_passport”, “address”
	 */
	public $type;
	
	/**
	 * @var string $field_name Name of the data field which has the error
	 */
	public $field_name;
	
	/**
	 * @var string $data_hash Base64-encoded data hash
	 */
	public $data_hash;
	
	/**
	 * @var string $message Error message
	 */
	public $message;
}
