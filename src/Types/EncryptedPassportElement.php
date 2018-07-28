<?php

namespace TelegramBot\Types;

/**
 * Contains information about documents or other Telegram Passport elements shared with the bot by the user.
 * Class EncryptedPassportElement
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement {
	
	/**
	 * @var string $type Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”,
	 *     “internal_passport”, “address”, “utility_bill”, “bank_statement”, “rental_agreement”,
	 *     “passport_registration”, “temporary_registration”, “phone_number”, “email”.
	 */
	public $type;
	
	/**
	 * @var string $data Optional. Base64-encoded encrypted Telegram Passport element data provided by the user,
	 *     available for “personal_details”, “passport”, “driver_license”, “identity_card”, “identity_passport” and
	 *     “address” types. Can be decrypted and verified using the accompanying EncryptedCredentials.
	 */
	public $data;
	
	/** @var string $phone_number Optional. User's verified phone number, available only for “phone_number” type */
	public $phone_number;
	
	/** @var string $email Optional. User's verified email address, available only for “email” type */
	public $email;
	
	/**
	 * @var PassportFile[] $files Optional. Array of encrypted files with documents provided by the user, available for
	 *     “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration”
	 *     types. Files can be decrypted and verified using the accompanying EncryptedCredentials.
	 */
	public $files;
	
	/**
	 * @var PassportFile $front_side Optional. Encrypted file with the front side of the document, provided by the
	 *     user. Available for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be
	 *     decrypted and verified using the accompanying EncryptedCredentials.
	 */
	public $front_side;
	
	/**
	 * @var PassportFile $reverse_side Optional. Encrypted file with the reverse side of the document, provided by the
	 *     user. Available for “driver_license” and “identity_card”. The file can be decrypted and verified using the
	 *     accompanying EncryptedCredentials.
	 */
	public $reverse_side;
	
	/**
	 * @var PassportFile $selfie Optional. Encrypted file with the selfie of the user holding a document, provided by
	 *     the user; available for “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can
	 *     be decrypted and verified using the accompanying EncryptedCredentials.
	 */
	public $selfie;
}
