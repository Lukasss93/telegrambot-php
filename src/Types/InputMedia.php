<?php

namespace TelegramBot\Types;

abstract class InputMedia
{
    /**
     * Type of the result
     */
    public string $type;

    /**
     * File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>”
     * to upload a new one using multipart/form-data under <file_attach_name> name.
     * @see https://core.telegram.org/bots/api#sending-files More info on Sending Files
     * @var string|resource $media
     */
    public mixed $media;

    /**
     * Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return get_object_vars($this);
    }
}