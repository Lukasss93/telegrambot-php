<?php

namespace TelegramBot\Types;

/**
 * This object contains information about a poll.
 * @package TelegramBot\Types
 */
class Poll {
	/** @var string Unique poll identifier */
	public $id;
	
	/** @var string Poll question, 1-255 characters */
	public $question;
	
	/** @var PollOption[] List of poll options */
	public $options;
	
	/** @var bool True, if the poll is closed */
	public $is_closed;
}
