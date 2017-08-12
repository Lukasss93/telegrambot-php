<?php

/** Helper for Uploading file using CURL */
if (!function_exists('curl_file_create')) {
	function curl_file_create($filename, $mimetype = '', $postname = '')
	{
		return "@$filename;filename=" . ($postname ?: basename($filename)) . ($mimetype ? ";type=$mimetype" : '');
	}
}

/** Helper for Uploading file using CURL with auto mime
 * @param string $path Full path file
 * @param string $postname
 * @return string
 */
function curl_file_create_auto_mime($path, $postname = '')
{
	return curl_file_create($path, '', $postname);
}

/** Check if a string is a json
 * @param string $string
 * @return bool
 */
function is_json($string)
{
	return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}