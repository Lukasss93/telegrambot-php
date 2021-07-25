<?php

namespace TelegramBot\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all group and supergroup chat administrators.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopeallchatadministrators
 */
class BotCommandScopeAllChatAdministrators
{
    /**
     * Scope type, must be all_chat_administrators
     * @var string $type
     */
    public $type;
}
