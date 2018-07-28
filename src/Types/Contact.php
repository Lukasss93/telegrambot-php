<?php

namespace TelegramBot\Types;

/** This object represents a phone contact. */
class Contact {
	/** @var string Contact's phone number */
	public $phone_number;
	
	/** @var string Contact's first name */
	public $first_name;
	
	/** @var string Optional. Contact's last name */
	public $last_name;
	
	/** @var int Optional. Contact's user identifier in Telegram */
	public $user_id;
	
	/** @var string $vcard Optional. Additional data about the contact in the form of a vCard*/
	public $vcard;
}
