<?php
/**
 * Created by PhpStorm.
 * User: PLUS-SW
 * Date: 17/01/2017
 * Time: 11:22
 */

namespace TelegramBot;


use Exception;

class TelegramException extends Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}";
	}
}
