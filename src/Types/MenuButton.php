<?php

namespace TelegramBot\Types;

use RuntimeException;

/**
 * This object describes the bot's menu button in a private chat. It should be one of
 * - {@see https://core.telegram.org/bots/api#menubuttoncommands MenuButtonCommands}
 * - {@see https://core.telegram.org/bots/api#menubuttonwebapp MenuButtonWebApp}
 * - {@see https://core.telegram.org/bots/api#menubuttondefault MenuButtonDefault}
 *
 * If a menu button other than MenuButtonDefault is set for a private chat, then it is applied in the chat.
 * Otherwise the default menu button is applied. By default, the menu button opens the list of bot commands.
 * @see https://core.telegram.org/bots/api#menubutton
 */
class MenuButton
{
    use MenuButtonCommands, MenuButtonWebApp, MenuButtonDefault;

    public function getType(): ?string
    {
        return match ($this->type) {
            'commands' => MenuButtonCommands::class,
            'webapp' => MenuButtonWebApp::class,
            'default' => MenuButtonDefault::class,
            default => throw new RuntimeException('Invalid MenuButton type'),
        };
    }
}
