<?php

namespace TelegramBot\Types;

/**
 * Contains information about Telegram Passport data shared with the bot by the user.
 * Class PassportData
 * @package TelegramBot\Types
 * @link https://core.telegram.org/bots/api#passportdata
 */
class PassportData {
	
	/** @var EncryptedPassportElement[] $data Array with information about documents and other Telegram Passport elements that was shared with the bot */
	public $data;
	
	/** @var EncryptedCredentials $credentials Encrypted credentials required to decrypt the data*/
	public $credentials;
}
