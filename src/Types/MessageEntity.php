<?php

namespace TelegramBot\Types;

/**
 * This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 * @see https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity
{
    /**
     * Type of the entity. Can be
     * - “mention“ (&#64;username)
     * - “hashtag” (#hashtag)
     * - “cashtag” ($USD)
     * - “bot_command” (/start&#64;jobs_bot)
     * - “url” (https://telegram.org)
     * - “email” (do-not-reply&#64;telegram.org)
     * - “phone_number” (+1-212-555-0123)
     * - “bold” (bold text)
     * - “italic” (italic text)
     * - “underline” (underlined text)
     * - “strikethrough” (strikethrough text)
     * - “spoiler” (spoiler message)
     * - “code” (monowidth string)
     * - “pre” (monowidth block)
     * - “text_link” (for clickable text URLs)
     * - “text_mention” (for users without usernames)
     * @var string $type
     */
    public $type;

    /**
     * Offset in UTF-16 code units to the start of the entity
     * @var int $offset
     */
    public $offset;

    /**
     * Length of the entity in UTF-16 code units
     * @var int $length
     */
    public $length;

    /**
     * Optional. For “text_link” only, url that will be opened after user taps on the text
     * @var string $url
     */
    public $url;

    /**
     * Optional. For “text_mention” only, the mentioned user
     * @var User $user
     */
    public $user;

    /**
     * Optional. For “pre” only, the programming language of the entity text
     * @var string $language
     */
    public $language;
}
