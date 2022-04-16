<?php

namespace TelegramBot\Enums;

class PassportSources extends Enum
{
    public const DATA = 'data';
    public const FRONT_SIDE = 'front_side';
    public const REVERSE_SIDE = 'reverse_side';
    public const SELFIE = 'selfie';
    public const FILE = 'file';
    public const FILES = 'files';
}
