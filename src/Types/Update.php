<?php

namespace TelegramBot\Types;

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
}