<?php

namespace TelegramBot;

use Illuminate\Support\Traits\Macroable;
use TelegramBot\Endpoints\AvailableMethods;
use TelegramBot\Endpoints\Games;
use TelegramBot\Endpoints\InlineMode;
use TelegramBot\Endpoints\Passport;
use TelegramBot\Endpoints\Payments;
use TelegramBot\Endpoints\Stickers;
use TelegramBot\Endpoints\UpdatesMessages;

trait Client
{
    use AvailableMethods,
        Games,
        InlineMode,
        Passport,
        Payments,
        Stickers,
        UpdatesMessages,
        Macroable;
}
