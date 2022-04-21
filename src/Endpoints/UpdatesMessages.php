<?php

namespace TelegramBot\Endpoints;

use TelegramBot\TelegramBot;
use TelegramBot\Types\Message;
use TelegramBot\Types\Poll;

/**
 * @mixin TelegramBot
 */
trait UpdatesMessages
{
    /**
     * Use this method to edit text and {@see https://core.telegram.org/bots/api#games game} messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param array $opt Optional parameters
     * @return Message|bool
     */
    public function editMessageText(string $text, array $opt = []): Message|bool
    {
        $required = compact('text');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param array $opt Optional parameters
     * @return bool|Message
     */
    public function editMessageCaption(array $opt = []): Message|bool
    {
        return $this->requestJson(__FUNCTION__, $opt, Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages.
     * If a message is part of a message album, then it can be edited only to an audio for audio albums,
     * only to a document for document albums and to a photo or a video otherwise.
     * When an inline message is edited, a new file can't be uploaded.
     * Use a previously uploaded file via its file_id or specify a URL.
     * On success, if the edited message was sent by the bot,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagemedia
     * @param mixed $media An InputMedia object for a new media content of the message
     * @param array $opt Optional parameters
     * @param array $clientOpt Client parameters
     * @return Message|bool
     */
    public function editMessageMedia(mixed $media, array $opt = [], array $clientOpt = []): Message|bool
    {
        $required = ['media' => json_encode($media, JSON_THROW_ON_ERROR)];
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), Message::class, $clientOpt);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param array $opt Optional parameters
     * @return Message|bool
     */
    public function editMessageReplyMarkup(array $opt = []): Message|bool
    {
        return $this->requestJson(__FUNCTION__, $opt, Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped {@see https://core.telegram.org/bots/api#poll Poll} with the final results is returned.
     * @see https://core.telegram.org/bots/api#stoppoll
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the original message with the poll
     * @param array $opt Optional parameters
     * @return Poll
     */
    public function stopPoll(int|string $chat_id, int $message_id, array $opt = []): Poll
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:
     * - A message can only be deleted if it was sent less than 48 hours ago.
     * - A dice message in a private chat can only be deleted if it was sent more than 24 hours ago.
     * - Bots can delete outgoing messages in private chats, groups, and supergroups.
     * - Bots can delete incoming messages in private chats.
     * - Bots granted can_post_messages permissions can delete outgoing messages in channels.
     * - If the bot is an administrator of a group, it can delete any message there.
     * - If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.
     *
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the message to delete
     * @return bool
     */
    public function deleteMessage(int|string $chat_id, int $message_id): bool
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, $required);
    }
}
