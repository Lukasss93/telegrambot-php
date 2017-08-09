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
        if($this->callback_query!==null)
        {
            return TelegramUpdateTypes::CALLBACK_QUERY;
        }
        else if($this->inline_query!==null)
        {
            return TelegramUpdateTypes::INLINE_QUERY;
        }
        else if($this->edited_message!==null)
        {
            return TelegramUpdateTypes::EDITED_MESSAGE;
        }
        else if($this->message->reply_to_message!==null)
        {
            return TelegramUpdateTypes::REPLY;
        }
        else if($this->message->forward_from!==null)
        {
            return TelegramUpdateTypes::FORWARD_USER;
        }
        else if($this->message->forward_from_chat!==null)
        {
            return TelegramUpdateTypes::FORWARD_CHAT;
        }
        else if($this->message->text!==null)
        {
            return TelegramUpdateTypes::MESSAGE;
        }
        else if($this->message->game!==null)
        {
            return TelegramUpdateTypes::GAME;
        }
        else if($this->message->sticker!==null)
        {
            return TelegramUpdateTypes::STICKER;
        }
        else if($this->message->photo!==null)
        {
            return TelegramUpdateTypes::PHOTO;
        }
        else if($this->message->video!==null)
        {
            return TelegramUpdateTypes::VIDEO;
        }
        else if($this->message->audio!==null)
        {
            return TelegramUpdateTypes::AUDIO;
        }
        else if($this->message->voice!==null)
        {
            return TelegramUpdateTypes::VOICE;
        }
        else if($this->message->contact!==null)
        {
            return TelegramUpdateTypes::CONTACT;
        }
        else if($this->message->document!==null)
        {
            return TelegramUpdateTypes::DOCUMENT;
        }
        else if($this->message->location!==null)
        {
            return TelegramUpdateTypes::LOCATION;
        }
        else if($this->message->venue!==null)
        {
            return TelegramUpdateTypes::VENUE;
        }
        else if($this->message->video_note!==null)
        {
            return TelegramUpdateTypes::VIDEO_NOTE;
        }
        else if($this->message->pinned_message!==null)
        {
            return TelegramUpdateTypes::PINNED_MESSAGE;
        }
        else if($this->message->invoice!==null)
        {
            return TelegramUpdateTypes::INVOICE;
        }
        else if($this->message->successful_payment!==null)
        {
            return TelegramUpdateTypes::SUCCESSFUL_PAYMENT;
        }

        return false;
    }
}