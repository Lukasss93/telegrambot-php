<?php

namespace TelegramBot\Types;

use TelegramBot\TelegramUpdateTypes;

/**
 * This object represents an incoming update.
 * At most one of the optional parameters can be present in any given update.
 */
class Update
{
    /**
     * @var int The update‘s unique identifier.
     * Update identifiers start from a certain positive number and increase sequentially.
     * This ID becomes especially handy if you’re using Webhooks, since it allows you to ignore
     * repeated updates or to restore the correct update sequence, should they get out of order.
     */
    public $update_id;

    /** @var Message Optional. New incoming message of any kind — text, photo, sticker, etc. */
    public $message;

    /** @var Message Optional. New version of a message that is known to the bot and was edited */
    public $edited_message;

    /** @var Message Optional. New incoming channel post of any kind — text, photo, sticker, etc. */
    public $channel_post;

    /** @var Message Optional. New version of a channel post that is known to the bot and was edited */
    public $edited_channel_post;

    /** @var InlineQuery Optional. New incoming inline query */
    public $inline_query;

    /** @var ChosenInlineResult Optional. The result of an inline query that was chosen by a user and sent to their chat partner. */
    public $chosen_inline_result;

    /** @var CallbackQuery Optional. New incoming callback query */
    public $callback_query;
    
    /** @var ShippingQuery Optional. New incoming shipping query. Only for invoices with flexible price */
    public $shipping_query;
    
    /** @var PreCheckoutQuery Optional. New incoming pre-checkout query. Contains full information about checkout */
    public $pre_checkout_query;

    /**
     * Return the current update type
     * @return false|string
     */
    public function getUpdateType()
    {
        if(!is_null($this->callback_query))
        {
            return TelegramUpdateTypes::CALLBACK_QUERY;
        }
        if(!is_null($this->edited_message))
        {
            return TelegramUpdateTypes::EDITED_MESSAGE;
        }
        if(!is_null($this->message->reply_to_message))
        {
            return TelegramUpdateTypes::REPLY;
        }
        if(!is_null($this->message->forward_from))
        {
            return TelegramUpdateTypes::FORWARD_USER;
        }
        if(!is_null($this->message->forward_from_chat))
        {
            return TelegramUpdateTypes::FORWARD_CHAT;
        }
        if(!is_null($this->message->text))
        {
            return TelegramUpdateTypes::MESSAGE;
        }
        if(!is_null($this->message->game))
        {
            return TelegramUpdateTypes::GAME;
        }
        if(!is_null($this->message->sticker))
        {
            return TelegramUpdateTypes::STICKER;
        }
        if(!is_null($this->message->photo))
        {
            return TelegramUpdateTypes::PHOTO;
        }
        if(!is_null($this->message->video))
        {
            return TelegramUpdateTypes::VIDEO;
        }
        if(!is_null($this->message->audio))
        {
            return TelegramUpdateTypes::AUDIO;
        }
        if(!is_null($this->message->voice))
        {
            return TelegramUpdateTypes::VOICE;
        }
        if(!is_null($this->message->contact))
        {
            return TelegramUpdateTypes::CONTACT;
        }
        if(!is_null($this->message->document))
        {
            return TelegramUpdateTypes::DOCUMENT;
        }
        if(!is_null($this->message->location))
        {
            return TelegramUpdateTypes::LOCATION;
        }
        if(!is_null($this->message->venue))
        {
            return TelegramUpdateTypes::VENUE;
        }
        if(!is_null($this->message->video_note))
        {
            return TelegramUpdateTypes::VIDEO_NOTE;
        }
        if(!is_null($this->message->pinned_message))
        {
            return TelegramUpdateTypes::PINNED_MESSAGE;
        }
        if(!is_null($this->message->invoice))
        {
            return TelegramUpdateTypes::INVOICE;
        }
        if(!is_null($this->message->successful_payment))
        {
            return TelegramUpdateTypes::SUCCESSFUL_PAYMENT;
        }

        return false;
    }
}