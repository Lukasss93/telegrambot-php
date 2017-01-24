<?php

namespace TelegramBot\Types;

/** This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.  */
class MessageEntity
{
    /** @var string Type of the entity. Can be mention (@username), hashtag, bot_command, url, email, bold (bold text), italic (italic text), code (monowidth string), pre (monowidth block), text_link (for clickable text URLs), text_mention (for users without usernames) */
    public $type;

    /** @var int Offset in UTF-16 code units to the start of the entity */
    public $offset;

    /** @var int Length of the entity in UTF-16 code units */
    public $length;

    /** @var string Optional. For “text_link” only, url that will be opened after user taps on the text */
    public $url;

    /** @var User Optional. For “text_mention” only, the mentioned user */
    public $user;
}