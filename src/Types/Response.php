<?php

namespace TelegramBot\Types;

/** Response from an API request */
class Response {
	/** @var bool Response status */
	public $ok;
	
	/** @var int An Integer field but its contents are subject to change in the future. */
	public $error_code;
	
	/** @var string Optional field with a human-readable description of the result. */
	public $description;
	
	/** @var object Result object */
	public $result;
	
	/** @var ResponseParameters Optional field which can help to automatically handle the error. */
	public $parameters;
}
