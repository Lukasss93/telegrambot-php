<?php

namespace TelegramBot\Endpoints;

use JsonMapper_Exception;
use TelegramBot\TelegramBot;
use TelegramBot\TelegramException;
use TelegramBot\Types\BotCommand;
use TelegramBot\Types\Chat;
use TelegramBot\Types\ChatAdministratorRights;
use TelegramBot\Types\ChatInviteLink;
use TelegramBot\Types\ChatMember;
use TelegramBot\Types\ChatPermissions;
use TelegramBot\Types\File;
use TelegramBot\Types\MenuButton;
use TelegramBot\Types\Message;
use TelegramBot\Types\MessageId;
use TelegramBot\Types\User;
use TelegramBot\Types\UserProfilePhotos;

/**
 * @mixin TelegramBot
 */
trait AvailableMethods
{
    /**
     * A simple method for testing your bot's auth token.
     * Requires no parameters.
     * Returns basic information about the bot in form of a User object.
     * @return User
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getMe(): User
    {
        $data = $this->endpoint('getMe', [], false);
        $object = $this->mapper->map($data->result, new User());

        /** @var User $object */
        return $object;
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * If splitLongMessage property is true, Messages[] is returned.
     * @param array $parameters
     * @return Message|Message[]
     * @throws TelegramException text parameter not set.
     * @throws JsonMapper_Exception
     */
    public function sendMessage(array $parameters)
    {
        if ($this->splitLongMessage) {
            if (!isset($parameters['text'])) {
                throw new TelegramException('text parameter not set.');
            }

            /** @var Message[] $messagesResponse */
            $messagesResponse = [];
            $messages = mb_str_split($parameters['text'], 4096);

            foreach ($messages as $message) {
                $parameters['text'] = $message;
                $data = $this->endpoint('sendMessage', $parameters);

                /** @var Message $object */
                $object = $this->mapper->map($data->result, new Message());
                $messagesResponse[] = $object;
            }

            return $messagesResponse;
        }

        $data = $this->endpoint('sendMessage', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());

        return $object;
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function forwardMessage(array $parameters): Message
    {
        $response = $this->endpoint('forwardMessage', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to copy messages of any kind. The method is analogous to the method forwardMessages,
     * but the copied message doesn't have a link to the original message.
     * Returns the MessageId of the sent message on success.
     * @see https://core.telegram.org/bots/api#copymessage
     * @param array $parameters
     * @return MessageId
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function copyMessage(array $parameters): MessageId
    {
        $response = $this->endpoint('copyMessage', $parameters);

        /** @var MessageId $object */
        $object = $this->mapper->map($response->result, new MessageId());

        return $object;
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     * @param $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendPhoto($parameters): Message
    {
        $response = $this->endpoint('sendPhoto', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .mp3 format. On success, the sent Message is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     * For sending voice messages, use the sendVoice method instead.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendAudio(array $parameters): Message
    {
        $response = $this->endpoint('sendAudio', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send general files.
     * On success, the sent Message is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendDocument(array $parameters): Message
    {
        $response = $this->endpoint('sendDocument', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos
     * (other formats may be sent as Document). On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendVideo(array $parameters): Message
    {
        $response = $this->endpoint('sendVideo', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound). On success, the sent
     * Message is returned. Bots can currently send animation files of up to 50 MB in size, this limit may be changed
     * in the future.
     * @link https://core.telegram.org/bots/api#sendanimation
     * @param $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendAnimation($parameters): Message
    {
        $response = $this->endpoint('sendAnimation', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice
     * message. For this to work, your audio must be in an .ogg file encoded with OPUS
     * (other formats may be sent as Audio or Document). On success, the sent Message is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendVoice(array $parameters): Message
    {
        $response = $this->endpoint('sendVoice', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendVideoNote(array $parameters): Message
    {
        $response = $this->endpoint('sendVideoNote', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album.
     * Documents and audio files can be only group in an album with messages of the same type.
     * On success, an array of {@see https://core.telegram.org/bots/api#message Messages} that were sent is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendMediaGroup(array $parameters): Message
    {
        $response = $this->endpoint('sendMediaGroup', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send point on the map. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendLocation(array $parameters): Message
    {
        $response = $this->endpoint('sendLocation', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to edit live location messages sent by the bot or via the bot (for inline bots).
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to
     * stopMessageLiveLocation. On success, if the edited message was sent by the bot, the edited Message is returned,
     * otherwise True is returned.
     * @param array $parameters
     * @return Message|bool
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function editMessageLiveLocation(array $parameters)
    {
        $response = $this->endpoint('editMessageLiveLocation', $parameters);

        if (is_bool($response->result)) {
            $object = $response->result;
        } else {
            $object = $this->mapper->map($response->result, new Message());
        }

        /** @var Message|bool $object */
        return $object;
    }

    /**
     * Use this method to stop updating a live location message sent by the bot or via the bot (for inline bots) before
     * live_period expires. On success, if the message was sent by the bot, the sent Message is returned, otherwise
     * True is returned.
     * @param array $parameters
     * @return Message|bool
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function stopMessageLiveLocation(array $parameters)
    {
        $response = $this->endpoint('stopMessageLiveLocation', $parameters);

        if (is_bool($response->result)) {
            $object = $response->result;
        } else {
            $object = $this->mapper->map($response->result, new Message());
        }

        /** @var Message|bool $object */
        return $object;
    }

    /**
     * Use this method to send information about a venue. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendVenue(array $parameters): Message
    {
        $response = $this->endpoint('sendVenue', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send phone contacts. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendContact(array $parameters): Message
    {
        $response = $this->endpoint('sendContact', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send a native poll. A native poll can't be sent to a private chat. On success, the sent Message is returned.
     *
     * @param array $parameters
     *
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendPoll(array $parameters): Message
    {
        $response = $this->endpoint('sendPoll', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send an animated emoji that will display a random value.
     * On success, the sent Message is returned.
     * @see https://core.telegram.org/bots/api#senddice
     *
     * @param array $parameters
     *
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendDice(array $parameters): Message
    {
        $response = $this->endpoint('sendDice', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
     * status). Returns True on success.
     *
     * > Example: The {@see https://t.me/imagebot ImageBot} needs some time to process a request and upload the
     * > image. Instead of sending a text message along the lines of “Retrieving image, please wait…”, the bot may use
     * > {@see https://core.telegram.org/bots/api#sendchataction sendChatAction} with action = upload_photo.
     * > The user will see a “sending photo” status for the bot.
     *
     * We only recommend using this method when a response from the bot will take a noticeable amount of time to arrive.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $action Type of action to broadcast.
     * Choose one, depending on what the user is about to receive:
     * typing for {@see https://core.telegram.org/bots/api#sendmessage text messages},
     * upload_photo for {@see https://core.telegram.org/bots/api#sendphoto photos},
     * record_video or upload_video for {@see https://core.telegram.org/bots/api#sendvideo videos},
     * record_voice or upload_voice for {@see https://core.telegram.org/bots/api#sendvoice voice notes},
     * upload_document for {@see https://core.telegram.org/bots/api#senddocument general files},
     * choose_sticker for {@see https://core.telegram.org/bots/api#sendsticker stickers},
     * find_location for {@see https://core.telegram.org/bots/api#sendlocation location data},
     * record_video_note or upload_video_note for {@see https://core.telegram.org/bots/api#sendvideonote video notes}.
     * @return bool
     * @throws TelegramException
     */
    public function sendChatAction($chat_id, string $action): bool
    {
        $response = $this->endpoint('sendChatAction', ['chat_id' => $chat_id, 'action' => $action]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
     * @param int $user_id
     * @param null $offset
     * @param int $limit
     * @return UserProfilePhotos
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getUserProfilePhotos(int $user_id, $offset = null, $limit = 100): UserProfilePhotos
    {
        $parameters = [
            'user_id' => $user_id,
            'limit' => $limit,
        ];

        if ($offset !== null) {
            $parameters['offset'] = $offset;
        }

        $response = $this->endpoint('getUserProfilePhotos', $parameters);

        /** @var UserProfilePhotos $object */
        $object = $this->mapper->map($response->result, new UserProfilePhotos());

        return $object;
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size.
     * On success, a File object is returned.
     * The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>,
     * where <file_path> is taken from the response.
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling getFile again.
     * Note: This function may not preserve the original file name and MIME type.
     * You should save the file's MIME type and name (if available) when the File object is received.
     * @param string $file_id
     * @return File
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getFile(string $file_id): File
    {
        $response = $this->endpoint('getFile', ['file_id' => $file_id]);

        /** @var File $object */
        $object = $this->mapper->map($response->result, new File());

        return $object;
    }

    /**
     * Use this method to kick a user from a group or a supergroup.
     * In the case of supergroups, the user will not be able to return to the group
     * on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the group for this to work. Returns True on success.
     * Note: This will method only work if the ‘All Members Are Admins’ setting is off in the target group.
     * Otherwise members may only be removed by the group's creator or by the member that added them.
     * @param int|string $chat_id
     * @param int $user_id
     * @param ?int $until_date Optional. Date when the user will be unbanned, unix time.
     *                               If user is banned for more than 366 days or less than 30 seconds
     *                               from the current time they are considered to be banned forever
     * @param bool|null $revoke_messages Optional. Pass True to delete all messages from the chat
     *                                  for the user that is being removed.
     *                                  If False, the user will be able to see messages in the group that were
     *                                  sent before the user was removed. Always True for supergroups and channels.
     * @return bool
     * @throws TelegramException
     * @deprecated Use {@see banChatMember} method instead.
     */
    public function kickChatMember($chat_id, int $user_id, int $until_date = null, bool $revoke_messages = null): bool
    {
        return $this->banChatMember($chat_id, $user_id, $until_date, $revoke_messages);
    }

    /**
     * Use this method to kick a user from a group or a supergroup.
     * In the case of supergroups, the user will not be able to return to the group
     * on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the group for this to work. Returns True on success.
     * Note: This will method only work if the ‘All Members Are Admins’ setting is off in the target group.
     * Otherwise members may only be removed by the group's creator or by the member that added them.
     * @param int|string $chat_id
     * @param int $user_id
     * @param ?int $until_date Optional. Date when the user will be unbanned, unix time.
     *                               If user is banned for more than 366 days or less than 30 seconds
     *                               from the current time they are considered to be banned forever
     * @param bool|null $revoke_messages Optional. Pass True to delete all messages from the chat
     *                                  for the user that is being removed.
     *                                  If False, the user will be able to see messages in the group that were
     *                                  sent before the user was removed. Always True for supergroups and channels.
     * @return bool
     * @throws TelegramException
     */
    public function banChatMember($chat_id, int $user_id, int $until_date = null, bool $revoke_messages = null): bool
    {
        $options = [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ];

        if ($until_date !== null) {
            $options['until_date'] = $until_date;
        }

        if ($revoke_messages !== null) {
            $options['revoke_messages'] = $revoke_messages;
        }

        $response = $this->endpoint('banChatMember', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup.
     * The user will not return to the group automatically, but will be able to join via link, etc.
     * The bot must be an administrator in the group for this to work.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param bool $only_if_banned Do nothing if the user is not banned
     * @return bool
     * @throws TelegramException
     */
    public function unbanChatMember($chat_id, int $user_id, bool $only_if_banned = false): bool
    {
        $response = $this->endpoint(
            'unbanChatMember',
            [
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'only_if_banned' => $only_if_banned,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup
     * for this to work and must have the appropriate admin rights.
     * Pass True for all boolean parameters to lift restrictions from a user. Returns True on success.
     * @param array $parameters
     * @return bool
     * @throws TelegramException
     */
    public function restrictChatMember(array $parameters): bool
    {
        $response = $this->endpoint('restrictChatMember', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     * @param array $parameters
     * @return bool
     * @throws TelegramException
     */
    public function promoteChatMember(array $parameters): bool
    {
        $response = $this->endpoint('promoteChatMember', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format [at]supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param string $custom_title New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @return bool
     * @throws TelegramException
     */
    public function setChatAdministratorCustomTitle($chat_id, int $user_id, string $custom_title): bool
    {
        $response = $this->endpoint(
            'setChatAdministratorCustomTitle',
            [
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'custom_title' => $custom_title,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to ban a channel chat in a supergroup or a channel.
     * Until the chat is {@see https://core.telegram.org/bots/api#unbanchatsenderchat unbanned},
     * the owner of the banned chat won't be able to send messages on behalf of any of their channels.
     * The bot must be an administrator in the supergroup or channel for this
     * to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     */
    public function banChatSenderChat($chat_id, int $sender_chat_id): bool
    {
        $opt = [
            'chat_id' => $chat_id,
            'sender_chat_id' => $sender_chat_id,
        ];

        $response = $this->endpoint('banChatSenderChat', $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unban a previously banned channel chat in a supergroup or channel.
     * The bot must be an administrator for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;supergroupusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     */
    public function unbanChatSenderChat($chat_id, int $sender_chat_id): bool
    {
        $opt = [
            'chat_id' => $chat_id,
            'sender_chat_id' => $sender_chat_id,
        ];

        $response = $this->endpoint('unbanChatSenderChat', $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and must have the can_restrict_members admin rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format [at]supergroupusername)
     * @param ChatPermissions $permissions New default chat permissions
     * @return bool
     * @throws TelegramException
     */
    public function setChatPermissions($chat_id, ChatPermissions $permissions): bool
    {
        $response = $this->endpoint(
            'setChatPermissions',
            [
                'chat_id' => $chat_id,
                'permissions' => $permissions,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to export an invite link to a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns exported invite link as String on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @return string
     * @throws TelegramException
     */
    public function exportChatInviteLink($chat_id): string
    {
        $response = $this->endpoint(
            'exportChatInviteLink',
            [
                'chat_id' => $chat_id,
            ]
        );

        /** @var string $object */
        $object = $response->result;

        return $object;
    }

    /**
     * Use this method to create an additional invite link for a chat.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * The link can be revoked using the method
     * {@see https://core.telegram.org/bots/api#revokechatinvitelink revokeChatInviteLink}.
     * Returns the new invite link as {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param array $opt Optional parameters
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     */
    public function createChatInviteLink($chat_id, array $opt = []): ChatInviteLink
    {
        $options = array_merge([
            'chat_id' => $chat_id,
        ], $opt);

        $response = $this->endpoint('createChatInviteLink', $options);

        /** @var ChatInviteLink $object */
        $object = $this->mapper->map($response->result, new ChatInviteLink());

        return $object;
    }

    /**
     * Use this method to edit a non-primary invite link created by the bot.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns the edited invite link as a
     * {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param string $invite_link The invite link to edit
     * @param array $opt Optional parameters
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     */
    public function editChatInviteLink($chat_id, string $invite_link, array $opt = []): ChatInviteLink
    {
        $options = array_merge([
            'chat_id' => $chat_id,
            'invite_link' => $invite_link,
        ], $opt);

        $response = $this->endpoint('editChatInviteLink', $options);

        /** @var ChatInviteLink $object */
        $object = $this->mapper->map($response->result, new ChatInviteLink());

        return $object;
    }

    /**
     * Use this method to revoke an invite link created by the bot. If the primary link is revoked,
     * a new link is automatically generated.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns the revoked invite link as
     * {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param string $invite_link The invite link to edit
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     */
    public function revokeChatInviteLink($chat_id, string $invite_link): ChatInviteLink
    {
        $response = $this->endpoint('revokeChatInviteLink', [
            'chat_id' => $chat_id,
            'invite_link' => $invite_link,
        ]);

        /** @var ChatInviteLink $object */
        $object = $this->mapper->map($response->result, new ChatInviteLink());

        return $object;
    }

    /**
     * Use this method to approve a chat join request.
     * The bot must be an administrator in the chat for this to work and
     * must have the can_invite_users administrator right.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format [at]channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     */
    public function approveChatJoinRequest($chat_id, int $user_id): bool
    {
        $options = [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ];

        $response = $this->endpoint('approveChatJoinRequest', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to decline a chat join request.
     * The bot must be an administrator in the chat for this to work and
     * must have the can_invite_users administrator right. Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format [at]channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool
     * @throws TelegramException
     */
    public function declineChatJoinRequest($chat_id, int $user_id): bool
    {
        $options = [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ];

        $response = $this->endpoint('declineChatJoinRequest', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * Note: In regular groups (non-supergroups), this method will only work
     * if the ‘All Members Are Admins’ setting is off in the target group.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param mixed $photo [InputFile] New chat photo, uploaded using multipart/form-data
     * @return bool
     * @throws TelegramException
     */
    public function setChatPhoto($chat_id, $photo): bool
    {
        $response = $this->endpoint(
            'setChatPhoto',
            [
                'chat_id' => $chat_id,
                'photo' => $photo,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * Note: In regular groups (non-supergroups), this method will only work
     * if the ‘All Members Are Admins’ setting is off in the target group.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @return bool
     * @throws TelegramException
     */
    public function deleteChatPhoto($chat_id): bool
    {
        $response = $this->endpoint(
            'deleteChatPhoto',
            [
                'chat_id' => $chat_id,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the title of a chat.
     * Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * Note: In regular groups (non-supergroups), this method will only work
     * if the ‘All Members Are Admins’ setting is off in the target group.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param string $title New chat title, 1-255 characters
     * @return bool
     * @throws TelegramException
     */
    public function setChatTitle($chat_id, string $title): bool
    {
        $response = $this->endpoint(
            'setChatTitle',
            [
                'chat_id' => $chat_id,
                'title' => $title,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the description of a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must
     * have the appropriate admin rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                                format @channelusername)
     * @param ?string $description New chat description, 0-255 characters
     * @return bool
     * @throws TelegramException
     */
    public function setChatDescription($chat_id, string $description = null): bool
    {
        $options = ['chat_id' => $chat_id];

        if ($description !== null) {
            $options['description'] = $description;
        }

        $response = $this->endpoint('setChatDescription', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to pin a message in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’
     * admin right in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target
     *                                         supergroup/channel (in the format [at]username)
     * @param int $message_id Identifier of a message to pin
     * @param bool $disable_notification Pass true, if it is not necessary to send a notification to all group
     *                                         members about the new pinned message
     * @return bool
     * @throws TelegramException
     */
    public function pinChatMessage($chat_id, int $message_id, bool $disable_notification = false): bool
    {
        $options = [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
        ];

        if ($disable_notification) {
            $options['disable_notification'] = true;
        }

        $response = $this->endpoint('pinChatMessage', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unpin a message in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’
     * admin right in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup/channel
     *     (in the format [at]username)
     * @param int|null $message_id Identifier of a message to unpin. If not specified, the most recent pinned message (by sending date) will be unpinned.
     * @return bool
     * @throws TelegramException
     */
    public function unpinChatMessage($chat_id, ?int $message_id = null): bool
    {
        $parameters = [
            'chat_id' => $chat_id,
        ];

        if ($message_id !== null) {
            $parameters['message_id'] = $message_id;
        }

        $response = $this->endpoint('unpinChatMessage', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to clear the list of pinned messages in a chat.
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work
     * and must have the 'can_pin_messages' admin right in a supergroup or 'can_edit_messages' admin right in a channel.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup/channel
     *     (in the format [at]username)
     * @return bool
     * @throws TelegramException
     */
    public function unpinAllChatMessages($chat_id): bool
    {
        $response = $this->endpoint('unpinAllChatMessages', ['chat_id' => $chat_id]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     * @param int|string $chat_id
     * @return bool
     * @throws TelegramException
     */
    public function leaveChat($chat_id): bool
    {
        $response = $this->endpoint('leaveChat', ['chat_id' => $chat_id]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get up to date information about the chat
     * (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a Chat object on success.
     * @param int|string $chat_id
     * @return Chat
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChat($chat_id): Chat
    {
        $response = $this->endpoint('getChat', ['chat_id' => $chat_id], false);

        /** @var Chat $object */
        $object = $this->mapper->map($response->result, new Chat());

        return $object;
    }

    /**
     * Use this method to get a list of administrators in a chat.
     * On success, returns an Array of ChatMember objects that contains
     * information about all chat administrators except other bots.
     * If the chat is a group or a supergroup and no administrators were appointed, only the creator will be returned.
     * @param int|string $chat_id
     * @return ChatMember[]
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChatAdministrators($chat_id): array
    {
        $response = $this->endpoint('getChatAdministrators', ['chat_id' => $chat_id], false);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var ChatMember[] $object */
        $object = $this->mapper->mapArray($resultArray, [], ChatMember::class);

        return $object;
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     * @param int|string $chat_id
     * @return int
     * @throws TelegramException
     * @deprecated Use {@see getChatMemberCount} method instead
     */
    public function getChatMembersCount($chat_id): int
    {
        return $this->getChatMemberCount($chat_id);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     * @param int|string $chat_id
     * @return int
     * @throws TelegramException
     */
    public function getChatMemberCount($chat_id): int
    {
        $response = $this->endpoint('getChatMemberCount', ['chat_id' => $chat_id], false);

        /** @var int $object */
        $object = $response->result;

        return $object;
    }

    /**
     * Use this method to get information about a member of a chat.
     * Returns a ChatMember object on success.
     * @param int|string $chat_id
     * @param int $user_id
     * @return ChatMember
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChatMember($chat_id, int $user_id): ChatMember
    {
        $response = $this->endpoint(
            'getChatMember',
            [
                'chat_id' => $chat_id,
                'user_id' => $user_id,
            ],
            false
        );

        /** @var ChatMember $object */
        $object = $this->mapper->map($response->result, new ChatMember());

        return $object;
    }

    /**
     * Use this method to set a new group sticker set for a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this
     * method. Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @param string $sticker_set_name Name of the sticker set to be set as the group sticker set
     * @return bool
     * @throws TelegramException
     */
    public function setChatStickerSet($chat_id, string $sticker_set_name): bool
    {
        $response = $this->endpoint(
            'setChatStickerSet',
            ['chat_id' => $chat_id, 'sticker_set_name' => $sticker_set_name]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a group sticker set from a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this
     * method. Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @return bool
     * @throws TelegramException
     */
    public function deleteChatStickerSet($chat_id): bool
    {
        $response = $this->endpoint('deleteChatStickerSet', ['chat_id' => $chat_id]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards.
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     * On success, True is returned.
     * Alternatively, the user can be redirected to the specified Game URL.
     * For this option to work, you must first create a game for your bot via BotFather and accept the terms.
     * Otherwise, you may use links like telegram.me/your_bot?start=XXXX that open your bot with a parameter.     *
     * @param $parameters
     * @return bool
     * @throws TelegramException
     */
    public function answerCallbackQuery($parameters): bool
    {
        $response = $this->endpoint('answerCallbackQuery', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the list of the bot's commands. Returns True on success.
     * @see https://core.telegram.org/bots/api#setmycommands
     * @param BotCommand[] $commands A list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function setMyCommands(array $commands, array $opt = []): bool
    {
        $options = array_merge([
            'commands' => json_encode($commands, true),
        ], $opt);

        if (isset($options['scope'])) {
            $options['scope'] = json_encode($options['scope'], true);
        }

        $response = $this->endpoint('setMyCommands', $options);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete the list of the bot's commands for the given scope and user language.
     * After deletion, {@see https://core.telegram.org/bots/api#determining-list-of-commands higher level commands}
     * will be shown to affected users. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemycommands
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function deleteMyCommands(array $opt = []): bool
    {
        if (isset($opt['scope'])) {
            $opt['scope'] = json_encode($opt['scope'], true);
        }

        $response = $this->endpoint('setMyCommands', $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * UUse this method to get the current list of the bot's commands. Requires no parameters. Returns Array of BotCommand on success.
     * @see https://core.telegram.org/bots/api#getmycommands
     * @param array $opt Optional parameters
     * @return BotCommand[]
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getMyCommands(array $opt = []): array
    {
        if (isset($opt['scope'])) {
            $opt['scope'] = json_encode($opt['scope'], true);
        }

        $response = $this->endpoint('getMyCommands', $opt);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var BotCommand[] $object */
        $object = $this->mapper->mapArray($resultArray, [], BotCommand::class);

        return $object;
    }

    /**
     * Use this method to change the bot's menu button in a private chat, or the default menu button.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     * @param array $opt
     * @return bool
     * @throws TelegramException
     */
    public function setChatMenuButton(array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get the current value of the bot's menu button in a private chat, or the default menu button.
     * Returns {@see https://core.telegram.org/bots/api#menubutton MenuButton} on success.
     * @see https://core.telegram.org/bots/api#getchatmenubutton
     * @param array|null $opt
     * @return MenuButton|null
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getChatMenuButton(?array $opt = []): MenuButton
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

        /** @var MenuButton $object */
        $object = $this->mapper->map($response->result, new MenuButton());

        return $object;
    }

    /**
     * Use this method to change the default administrator rights requested by the bot
     * when it's added as an administrator to groups or channels.
     * These rights will be suggested to users, but they are are free to modify the list before adding the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
     * @param array $opt
     * @return bool
     * @throws TelegramException
     */
    public function setMyDefaultAdministratorRights(array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get the current default administrator rights of the bot.
     * Returns {@see https://core.telegram.org/bots/api#chatadministratorrights ChatAdministratorRights} on success.
     * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
     * @param array $opt
     * @return ChatAdministratorRights
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getMyDefaultAdministratorRights(array $opt = []): ChatAdministratorRights
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

        /** @var ChatAdministratorRights $object */
        $object = $this->mapper->map($response->result, new ChatAdministratorRights());

        return $object;
    }
}
