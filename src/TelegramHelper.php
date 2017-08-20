<?php

/** Check if a string is a json
 * @param string $string
 * @return bool
 */
function is_json($string)
{
	return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/** Curl file create with auto mime
 * @param string $path Full path file
 * @param string $postname
 * @return CURLFile
 */
function curl_file_create_automime($path, $postname = '')
{
	return curl_file_create($path, mime_content_type($path), $postname);
}
