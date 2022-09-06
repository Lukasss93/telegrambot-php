<?php

namespace TelegramBot\Enums;

use ReflectionClass;

abstract class Enum
{
    public static function all(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }
}
