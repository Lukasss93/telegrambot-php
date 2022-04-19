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
     * @param int $chat_id Unique identifier for the target chat
     * @param string $game_short_name Short name of the game, serves as the unique identifier for the game. Set up your games via {@see Unique identifier for the target chat Botfather}.
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendGame(int $chat_id, string $game_short_name, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'game_short_name' => $game_short_name,
        ], $opt));

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
     * @param int $user_id User identifier
     * @param int $score New score, must be non-negative
     * @param array $opt Optional parameters
     * @return bool|Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function setGameScore(int $user_id, int $score, array $opt = []): Message|bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'user_id' => $user_id,
            'score' => $score,
        ], $opt));

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
     *
     * > This method will currently return scores for the target user, plus two of their closest neighbors on each side.
     * > Will also return the top three users if the user and his neighbors are not among them.
     * > Please note that this behavior is subject to change.
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param int $user_id Target user id
     * @param array $opt Optional parameters
     * @return GameHighScore[]
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getGameHighScores(int $user_id, array $opt = []): array
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'user_id' => $user_id,
        ], $opt), false);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var GameHighScore[] $object */
        $object = $this->mapper->mapArray($resultArray, [], GameHighScore::class);

        return $object;
    }
}
