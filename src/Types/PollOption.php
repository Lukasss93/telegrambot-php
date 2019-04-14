<?php

namespace TelegramBot\Types;

/**
 * This object contains information about one answer option in a poll.
 * @package TelegramBot\Types
 */
class PollOption {
	/** @var string Option text, 1-100 characters */
	public $text;
	
	/** @var int Number of users that voted for this option */
	public $voter_count;
}
