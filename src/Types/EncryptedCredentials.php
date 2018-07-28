<?php

namespace TelegramBot\Types;

/**
 * Contains data required for decrypting and authenticating EncryptedPassportElement. See the Telegram Passport
 * Documentation (https://core.telegram.org/telegram-passport#receiving-information) for a complete description of the
 * data decryption and authentication processes.
 * Class EncryptedCredentials
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials {
	
	/**
	 * @var string $data Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and
	 *     secrets required for EncryptedPassportElement decryption and authentication
	 */
	public $data;
	
	/**
	 * @var string $hash Base64-encoded data hash for data authentication
	 */
	public $hash;
	
	/**
	 * @var string $secret Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
	 */
	public $secret;
}
