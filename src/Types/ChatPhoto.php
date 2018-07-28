<?php

namespace TelegramBot\Types;

/** This object represents a chat photo. */
class ChatPhoto {
	/** @var string Unique file identifier of small (160x160) chat photo. This file_id can be used only for photo download. */
	public $small_file_id;
	
	/** @var string Unique file identifier of big (640x640) chat photo. This file_id can be used only for photo download. */
	public $big_file_id;
}
