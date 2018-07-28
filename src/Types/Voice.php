<?php

namespace TelegramBot\Types;

/** This object represents a voice note. */
class Voice {
	/** @var string Unique identifier for this file */
	public $file_id;
	
	/** @var int Duration of the audio in seconds as defined by sender */
	public $duration;
	
	/** @var string Optional. MIME type of the file as defined by sender */
	public $mime_type;
	
	/** @var int Optional. File size */
	public $file_size;
}
