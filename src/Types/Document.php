<?php

namespace TelegramBot\Types;

/** This object represents a general file (as opposed to PhotoSize, Voice messages and Audio files). */
class Document {
	/** @var string Unique file identifier */
	public $file_id;
	
	/** @var PhotoSize Optional. Document thumbnail as defined by sender */
	public $thumb;
	
	/** @var string Optional. Original filename as defined by sender */
	public $file_name;
	
	/** @var string Optional. MIME type of the file as defined by sender */
	public $mime_type;
	
	/** @var int Optional. File size */
	public $file_size;
}
