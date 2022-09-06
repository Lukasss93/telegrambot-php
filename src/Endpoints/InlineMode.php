<?php

namespace TelegramBot\Endpoints;

use TelegramBot\TelegramBot;
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
     * @param string $inline_query_id Unique identifier for the answered query
     * @param array $results An array of results for the inline query
     * @param array $opt Optional parameters
     * @return bool
     */
    public function answerInlineQuery(string $inline_query_id, array $results, array $opt = []): bool
    {
        $required = compact('inline_query_id');
        $required['results'] = json_encode($results, JSON_THROW_ON_ERROR);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to set the result of an interaction with a {@see https://core.telegram.org/bots/webapps Web App}
     * and send a corresponding message on behalf of the user to the chat from which the query originated.
     * On success, a {@see https://core.telegram.org/bots/api#sentwebappmessage SentWebAppMessage} object is returned.
     * @see https://core.telegram.org/bots/api#answerwebappquery
     * @param string $web_app_query_id Unique identifier for the query to be answered
     * @param InlineQueryResult $result An InlineQueryResult object describing the message to be sent
     * @return SentWebAppMessage
     */
    public function answerWebAppQuery(string $web_app_query_id, InlineQueryResult $result): SentWebAppMessage
    {
        $required = compact('web_app_query_id');
        $required['result'] = json_encode($result, JSON_THROW_ON_ERROR);
        return $this->requestJson(__FUNCTION__, $required, SentWebAppMessage::class);
    }
}
