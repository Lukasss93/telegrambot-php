<?php

namespace TelegramBot\Endpoints;

use JsonException;
use JsonMapper_Exception;
use TelegramBot\TelegramBot;
use TelegramBot\TelegramException;
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
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @throws JsonException
     */
    public function sendInvoice(
        int|string $chat_id,
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        array $opt = [],
    ): Message {
        $data = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'title' => $title,
            'description' => $description,
            'payload' => $payload,
            'provider_token' => $provider_token,
            'currency' => $currency,
            'prices' => json_encode($prices, JSON_THROW_ON_ERROR),
        ], $opt);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());

        return $object;
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
     * @throws TelegramException
     */
    public function answerShippingQuery(string $shipping_query_id, bool $ok, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'shipping_query_id' => $shipping_query_id,
            'ok' => $ok,
        ], $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
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
     * @throws TelegramException
     */
    public function answerPreCheckoutQuery(string $pre_checkout_query_id, bool $ok, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'pre_checkout_query_id' => $pre_checkout_query_id,
            'ok' => $ok,
        ], $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }
}
