<?php

namespace TelegramBot\Endpoints;

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
     * @param array $parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendInvoice(array $parameters): Message
    {
        $data = $this->endpoint('sendInvoice', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());

        return $object;
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API
     * will send an {@see https://core.telegram.org/bots/api#update Update} with a shipping_query field to the bot.
     * Use this method to reply to shipping queries. On success, True is returned.
     * @see https://core.telegram.org/bots/api#answershippingquery
     * @param object[] $parameters
     * @return bool
     * @throws TelegramException
     */
    public function answerShippingQuery(array $parameters): bool
    {
        $response = $this->endpoint('answerShippingQuery', $parameters);

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
     * @param object[] $parameters
     * @return bool
     * @throws TelegramException
     */
    public function answerPreCheckoutQuery(array $parameters): bool
    {
        $response = $this->endpoint('answerPreCheckoutQuery', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }
}
