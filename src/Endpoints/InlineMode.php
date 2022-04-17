<?php

namespace TelegramBot\Endpoints;

use JsonException;
use JsonMapper_Exception;
use TelegramBot\TelegramBot;
use TelegramBot\TelegramException;
use TelegramBot\Types\InlineQueryResult;
use TelegramBot\Types\SentWebAppMessage;

/**
 * @mixin TelegramBot
 */
trait InlineMode
{
    /**
     * Use this method to send answers to an inline query. On success, True is returned.
     * No more than 50 results per query are allowed.
     * @see https://core.telegram.org/bots/api#answerinlinequery
     * @param array $parameters
     * @return bool
     * @throws TelegramException
     */
    public function answerInlineQuery(array $parameters): bool
    {
        $response = $this->endpoint('answerInlineQuery', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set the result of an interaction with a Web App and send a corresponding message
     * on behalf of the user to the chat from which the query originated.
     * On success, a {@see https://core.telegram.org/bots/api#sentwebappmessage SentWebAppMessage} object is returned.
     * @param string $web_app_query_id Unique identifier for the query to be answered
     * @param InlineQueryResult $result A JSON-serialized object describing the message to be sent
     * @return SentWebAppMessage
     * @throws TelegramException
     * @throws JsonMapper_Exception
     * @throws JsonException
     */
    public function answerWebAppQuery(string $web_app_query_id, InlineQueryResult $result): SentWebAppMessage
    {
        $data = $this->endpoint('sendInvoice', [
            'web_app_query_id' => $web_app_query_id,
            'result' => json_encode($result, JSON_THROW_ON_ERROR),
        ]);

        /** @var SentWebAppMessage $object */
        $object = $this->mapper->map($data->result, new SentWebAppMessage());

        return $object;
    }
}
