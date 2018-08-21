<?php

/**
 * Check if a string is a json
 * @param string $string
 * @return bool
 */
function is_json($string) {
	return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/**
 * Curl file create with auto mime
 * @param string $path Full path file
 * @param string $postname
 * @return CURLFile
 */
function curl_file_create_automime($path, $postname = '') {
	return curl_file_create($path, mime_content_type($path), $postname);
}

/**
 * Split an unicode string
 * @param $string
 * @param int $split_length
 * @return array|array[]|bool|false|string[]
 */
function mb_str_split($string, $split_length = 1) {
	if($split_length == 1) {
		return preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
	}
	else if($split_length > 1) {
		$return_value = [];
		$string_length = mb_strlen($string, "UTF-8");
		for($i = 0; $i < $string_length; $i += $split_length) {
			$return_value[] = mb_substr($string, $i, $split_length, "UTF-8");
		}
		return $return_value;
	}
	else {
		return false;
	}
}
