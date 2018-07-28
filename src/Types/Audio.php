<?php

namespace TelegramBot\Types;

/** This object represents an audio file to be treated as music by the Telegram clients. */
class Audio {
	/** @var string Unique identifier for this file */
	public $file_id;
	
	/** @var int Duration of the audio in seconds as defined by sender */
	public $duration;
	
	/** @var string Optional. Performer of the audio as defined by sender or by audio tags */
	public $performer;
	
	/** @var string Optional. Title of the audio as defined by sender or by audio tags */
	public $title;
	
	/** @var string Optional. MIME type of the file as defined by sender */
	public $mime_type;
	
	/** @var int Optional. File size */
	public $file_size;
	
	/** @var PhotoSize $thumb Optional. Thumbnail of the album cover to which the music file belongs */
	public $thumb;
}
