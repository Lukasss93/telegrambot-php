<?php

namespace TelegramBot\Endpoints;

use JsonMapper_Exception;
use TelegramBot\TelegramBot;
use TelegramBot\TelegramException;
use TelegramBot\Types\GameHighScore;
use TelegramBot\Types\Message;

/**
 * @mixin TelegramBot
 */
trait Games
{
    /**
     * Use this method to send a game.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendgame
     * @param array $parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendGame(array $parameters): Message
    {
        $response = $this->endpoint('sendGame', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to set the score of the specified user in a game.
     * On success, if the message was sent by the bot,
     * returns the edited {@see https://core.telegram.org/bots/api#message Message}, otherwise returns True.
     * Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
     * @see https://core.telegram.org/bots/api#setgamescore
     * @param $parameters
     * @return bool|Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function setGameScore(array $parameters)
    {
        $response = $this->endpoint('setGameScore', $parameters);

        if (is_bool($response->result)) {
            /** @var bool $object */
            $object = $response->result;

            return $object;
        }

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to get data for high score tables.
     * Will return the score of the specified user and several of their neighbors in a game.
     * On success, returns an Array of {@see https://core.telegram.org/bots/api#gamehighscore GameHighScore} objects.
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param array $parameters
     * @return GameHighScore[]
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getGameHighScores(array $parameters): array
    {
        $response = $this->endpoint('getGameHighScores', $parameters, false);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var GameHighScore[] $object */
        $object = $this->mapper->mapArray($resultArray, [], GameHighScore::class);

        return $object;
    }
}
