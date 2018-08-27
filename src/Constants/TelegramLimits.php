<?php
/**
 * Created by PhpStorm.
 * User: Luca Patera
 * Date: 27/08/2018
 * Time: 23:30
 */

namespace TelegramBot\Constants;


class TelegramLimits {
	
	/**
	 * Download file limit in Byte. (20 MB)
	 * For the moment, bots can download files of up to 20MB in size.
	 */
	const DOWNLOAD=20971520;
	
	/**
	 * Upload file limit in Byte. (50 MB)
	 */
	const UPLOAD=52428800;
}
