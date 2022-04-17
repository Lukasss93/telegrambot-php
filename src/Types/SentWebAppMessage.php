<?php

namespace TelegramBot\Types;

/**
 * Contains information about an inline message sent
 * by a {@see https://core.telegram.org/bots/webapps Web App} on behalf of a user.
 * @see https://core.telegram.org/bots/api#sentwebappmessage
 */
class SentWebAppMessage
{
    /**
     * Optional. Identifier of the sent inline message.
     * Available only if there is an {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup inline keyboard}
     * attached to the message.
     */
    public ?string $inline_message_id = null;
}
