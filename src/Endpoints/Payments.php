<?php

namespace TelegramBot\Endpoints;

use TelegramBot\TelegramBot;
use TelegramBot\Types\Message;

/**
 * @mixin TelegramBot
 */
trait Payments
{
    /**
     * Use this method to send invoices.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendinvoice
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $title Product name, 1-32 characters
     * @param string $description Product description, 1-255 characters
     * @param string $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @param string $provider_token Payments provider token, obtained via {@see https://t.me/botfather Botfather}
     * @param string $currency Three-letter ISO 4217 currency code, see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @param array $prices Price breakdown, a list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @param array $opt Optional parameters
     * @return Message
     */
    public function sendInvoice(int|string $chat_id, string $title, string $description, string $payload, string $provider_token, string $currency, array $prices, array $opt = []): Message
    {
        $required = compact('chat_id', 'title', 'description', 'payload', 'provider_token', 'currency');
        $required['prices'] = json_encode($prices, JSON_THROW_ON_ERROR);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API
     * will send an {@see https://core.telegram.org/bots/api#update Update} with a shipping_query field to the bot.
     * Use this method to reply to shipping queries. On success, True is returned.
     * @see https://core.telegram.org/bots/api#answershippingquery
     * @param string $shipping_query_id Unique identifier for the query to be answered
     * @param bool $ok Specify True if delivery to the specified address is possible and False if there are any problems (for example, if delivery to the specified address is not possible)
     * @param array $opt Optional parameters
     * @return bool
     */
    public function answerShippingQuery(string $shipping_query_id, bool $ok, array $opt = []): bool
    {
        $required = compact('shipping_query_id', 'ok');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation
     * in the form of an {@see https://core.telegram.org/bots/api#update Update} with the field pre_checkout_query.
     * Use this method to respond to such pre-checkout queries.
     * On success, True is returned.
     * Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query was sent.
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     * @param string $pre_checkout_query_id Unique identifier for the query to be answered
     * @param bool $ok Specify True if everything is alright (goods are available, etc.) and the bot is ready to proceed with the order. Use False if there are any problems.
     * @param array $opt Optional parameters
     * @return bool
     */
    public function answerPreCheckoutQuery(string $pre_checkout_query_id, bool $ok, array $opt = []): bool
    {
        $required = compact('pre_checkout_query_id', 'ok');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }
}
