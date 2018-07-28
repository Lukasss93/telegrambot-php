<?php

namespace TelegramBot\Types;

/** This object represents a video file. */
class Video {
	/** @var string Unique identifier for this file */
	public $file_id;
	
	/** @var int Video width as defined by sender */
	public $width;
	
	/** @var int Video height as defined by sender */
	public $height;
	
	/** @var int Duration of the video in seconds as defined by sender */
	public $duration;
	
	/** @var PhotoSize Optional. Video thumbnail */
	public $thumb;
	
	/** @var string Optional. Mime type of a file as defined by sender */
	public $mime_type;
	
	/** @var int Optional. File size */
	public $file_size;
}
