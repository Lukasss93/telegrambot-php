<?php

namespace TelegramBot\Types;

/**
 * Response from an API request
 * @see https://core.telegram.org/bots/api#making-requests
 */
class Response
{
    /**
     * Response status
     * @var bool $ok
     */
    public $ok;
    
    /**
     * An Integer field but its contents are subject to change in the future.
     * @var int $error_code
     */
    public $error_code;
    
    /**
     * Optional field with a human-readable description of the result.
     * @var string $description
     */
    public $description;
    
    /**
     * Result data
     * @var object $result
     */
    public $result;
    
    /**
     * Optional field which can help to automatically handle the error.
     * @var ResponseParameters $parameters
     */
    public $parameters;
}
