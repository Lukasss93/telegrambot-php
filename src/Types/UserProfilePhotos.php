<?php

namespace TelegramBot\Types;

/** This object represent a user's profile pictures. */
class UserProfilePhotos {
	/** @var int Total number of profile pictures the target user has */
	public $total_count;
	
	/** @var PhotoSize[][] Requested profile pictures (in up to 4 sizes each) */
	public $photos;
}
