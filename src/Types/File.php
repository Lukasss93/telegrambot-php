<?php

namespace TelegramBot\Types;

/**
 * This object represents a file ready to be downloaded.
 * The file can be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>.
 * It is guaranteed that the link will be valid for at least 1 hour.
 * When the link expires, a new one can be requested by calling getFile.
 * Maximum file size to download is 20 MB.
 */
class File {
	/** @var string Unique identifier for this file */
	public $file_id;
	
	/** @var int Optional. File size, if known */
	public $file_size;
	
	/** @var string Optional. File path. Use https://api.telegram.org/file/bot<token>/<file_path> to get the file. */
	public $file_path;
}
