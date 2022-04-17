<?php

namespace TelegramBot\Types;

/**
 * Represents a menu button, which opens the bot's list of commands.
 * @see https://core.telegram.org/bots/api#menubuttoncommands
 */
trait MenuButtonCommands
{
    /**
     * Type of the button, must be commands
     */
    public string $type;
}
