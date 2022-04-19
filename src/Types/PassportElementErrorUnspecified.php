<?php

namespace TelegramBot\Types;

/**
 * Represents an issue in an unspecified place.
 * The error is considered resolved when new data is added.
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
trait PassportElementErrorUnspecified
{
    /**
     * Error source, must be unspecified
     */
    public string $source;

    /**
     * Type of element of the user's Telegram Passport which has the issue
     */
    public string $type;

    /**
     * Base64-encoded element hash
     */
    public ?string $element_hash = null;

    /**
     * Error message
     */
    public string $message;
}
