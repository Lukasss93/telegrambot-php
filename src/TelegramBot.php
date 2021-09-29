<?php

namespace TelegramBot;

use JsonMapper;
use JsonMapper_Exception;
use ReflectionClass;
use TelegramBot\Types\BotCommand;
use TelegramBot\Types\Chat;
use TelegramBot\Types\ChatInviteLink;
use TelegramBot\Types\ChatMember;
use TelegramBot\Types\ChatPermissions;
use TelegramBot\Types\File;
use TelegramBot\Types\GameHighScore;
use TelegramBot\Types\Message;
use TelegramBot\Types\MessageId;
use TelegramBot\Types\Response;
use TelegramBot\Types\StickerSet;
use TelegramBot\Types\Update;
use TelegramBot\Types\User;
use TelegramBot\Types\UserProfilePhotos;
use TelegramBot\Types\WebhookInfo;

/**
 * Class TelegramBot
 * For parameters of methods see: https://core.telegram.org/bots/api
 * @package TelegramBot
 */
class TelegramBot
{
    /** @var bool Automatic split message */
    public $splitLongMessage = false;

    /** @var Update Webhook update */
    public $webhookData;

    /** @var Update[] GetUpdates data */
    public $updatesData;

    /** @var string Bot token */
    private $token;

    /** @var JsonMapper */
    private $mapper;

    /** @var string Bot API server url */
    private $botServerUrl;

    /**
     * TelegramBot constructor
     * @param string $token Bot token
     * @param string $botServerUrl Bot API server url
     * @throws JsonMapper_Exception
     */
    public function __construct(string $token, string $botServerUrl = '')
    {
        //json mapper
        $this->mapper = new JsonMapper();
        $this->mapper->bStrictNullTypes = false;
        $this->mapper->undefinedPropertyHandler = static function ($object, $propName, $jsonValue) {
            $object->{$propName} = $jsonValue;
        };

        //telegram data
        $this->token = $token;
        $this->botServerUrl = $botServerUrl;
        $this->webhookData = $this->getWebhookUpdate();
    }

    //region GETTING UPDATES

    /**
     * Use this method to receive incoming updates using long polling (wiki). An Array of Update objects is returned.
     * Note: This method will not work if an outgoing webhook is set up.
     * @param int $offset Identifier of the first update to be returned. Must be greater by one than the highest
     *                      among the identifiers of previously received updates. By default, updates starting with the
     *                      earliest unconfirmed update are returned. An update is considered confirmed as soon as
     *                      getUpdates is called with an offset higher than its update_id.
     * @param int $limit Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults
     *                      to 100
     * @param int $timeout Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling
     * @param string[] $allowed_updates List the types of updates you want your bot to receive.
     *                              For example, specify [“message”, “edited_channel_post”, “callback_query”]
     *                              to only receive updates of these types.
     *                              See Update for a complete list of available update types.
     *                              Specify an empty list to receive all updates regardless of type (default).
     *                              If not specified, the previous setting will be used.
     *                              Please note that this parameter doesn't affect updates
     *                              created before the call to the getUpdates,
     *                              so unwanted updates may be received for a short period of time.
     * @return Update[]
     * @throws TelegramException|JsonMapper_Exception
     * @link https://core.telegram.org/bots/api#getupdates
     */
    public function getUpdates($offset = 0, $limit = 100, $timeout = 0, $allowed_updates = []): array
    {
        $parameters = ['offset' => $offset, 'limit' => $limit, 'timeout' => $timeout];
        if (count($allowed_updates) > 0) {
            $parameters['allowed_updates'] = $allowed_updates;
        }

        $response = $this->endpoint('getUpdates', $parameters);

        /** @var array $updates */
        $updates = $response->result;

        $this->updatesData = $this->mapper->mapArray($updates, [], Update::class);

        if (count($this->updatesData) >= 1) {
            $last_element_id = $this->updatesData[count($this->updatesData) - 1]->update_id + 1;
            $parameters = ['offset' => $last_element_id, 'limit' => 1, 'timeout' => 100];
            $this->endpoint('getUpdates', $parameters);
        }

        return $this->updatesData;
    }

    /**
     * Use this method to specify a url and receive incoming updates via an outgoing webhook.
     * Whenever there is an update for the bot, we will send an HTTPS POST request to the specified url,
     * containing a JSON-serialized Update.
     * In case of an unsuccessful request, we will give up after a reasonable amount of attempts.
     * Returns true.If you'd like to make sure that the Webhook request comes from Telegram,
     * we recommend using a secret path in the URL, e.g. https://www.example.com/<token>.
     * Since nobody else knows your bot‘s token, you can be pretty sure it’s us.
     *
     * Notes
     * 1. You will not be able to receive updates using getUpdates for as long as an outgoing webhook is set up.
     * 2. To use a self-signed certificate, you need to upload your public key certificate using certificate parameter.
     * Please upload as InputFile, sending a String will not work.
     * 3. Ports currently supported for Webhooks: 443, 80, 88, 8443.
     * NEW! If you're having any trouble setting up webhooks,
     * please check out this amazing guide to Webhooks: https://core.telegram.org/bots/webhooks.
     *
     * @param array $parameters
     * @return bool
     * @throws TelegramException
     */
    public function setWebhook(array $parameters): bool
    {
        if (isset($parameters['certificate'])) {
            $parameters['certificate'] = $this->encodeFile($parameters['certificate']);
        }

        $response = $this->endpoint('setWebhook', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates.
     * Returns True on success. Requires no parameters.
     * @param bool $drop_pending_updates Pass True to drop all pending updates
     * @return bool
     * @throws TelegramException
     */
    public function deleteWebhook(bool $drop_pending_updates = false): bool
    {
        $data = $this->endpoint('deleteWebhook', ['drop_pending_updates' => $drop_pending_updates]);

        /** @var bool $object */
        $object = property_exists($data->result, 'scalar') ? $data->result->scalar : $data->result;

        return $object;
    }

    /**
     * Use this method to get current webhook status.
     * Requires no parameters.
     * On success, returns a WebhookInfo object.
     * If the bot is using getUpdates, will return an object with the url field empty.
     * @return WebhookInfo
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getWebhookInfo(): WebhookInfo
    {
        $data = $this->endpoint('getWebhookInfo', [], false);

        /** @var WebhookInfo $object */
        $object = $this->mapper->map($data->result, new WebhookInfo());

        return $object;
    }

    /**
     * Incoming update from webhook
     * @return Update|null
     * @throws JsonMapper_Exception
     */
    public function getWebhookUpdate(): ?Update
    {
        $current = null;

        if ($this->webhookData === null) {
            $rawData = file_get_contents('php://input');
            $current = json_decode($rawData, false);

            $current = $current === null ? null : $this->mapper->map($current, new Update());
        } else {
            $current = $this->webhookData;
        }

        /** @var Update|null $current */
        return $current;
    }

    /**
     * Clear all updates stored on Telegram Server.
     * This method is an alias for "$this->getUpdates(-1);"
     * @throws TelegramException|JsonMapper_Exception
     */
    public function clearUpdates(): void
    {
        $this->getUpdates(-1);
    }

    //endregion

    //region AVAILABLE METHODS

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
     * status). Returns True on success. Example: The ImageBot needs some time to process a request and upload the
     * image. Instead of sending a text message along the lines of “Retrieving image, please wait…”, the bot may use
     * sendChatAction with action = upload_photo. The user will see a “sending photo” status for the bot. We only
     * recommend using this method when a response from the bot will take a noticeable amount of time to arrive.
     * @param int|string $chat_id
     * @param string $action
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
     * @param int|null $expire_date Optional. Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit Optional. Maximum number of users that can be members of the chat simultaneously
     * after joining the chat via this invite link; 1-99999
     * @return ChatInviteLink
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     */
    public function createChatInviteLink($chat_id, int $expire_date = null, int $member_limit = null): ChatInviteLink
    {
        $options = [
            'chat_id' => $chat_id,
        ];

        if ($expire_date !== null) {
            $options['expire_date'] = $expire_date;
        }

        if ($member_limit !== null) {
            $options['member_limit'] = $expire_date;
        }

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
     * @param int|null $expire_date Optional. Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit Optional. Maximum number of users that can be members of the chat simultaneously
     * after joining the chat via this invite link; 1-99999
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     */
    public function editChatInviteLink(
        $chat_id,
        string $invite_link,
        int $expire_date = null,
        int $member_limit = null
    ): ChatInviteLink {
        $options = [
            'chat_id' => $chat_id,
            'invite_link' => $invite_link,
        ];

        if ($expire_date !== null) {
            $options['expire_date'] = $expire_date;
        }

        if ($member_limit !== null) {
            $options['member_limit'] = $expire_date;
        }

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
     * @param BotCommand[] $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @return bool
     * @throws TelegramException
     */
    public function setMyCommands(array $commands): bool
    {
        $response = $this->endpoint('setMyCommands', ['commands' => json_encode($commands, true)]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete the list of the bot's commands for the given scope and user language.
     * After deletion, {@see https://core.telegram.org/bots/api#determining-list-of-commands higher level commands}
     * will be shown to affected users. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemycommands
     * @param array $commands
     * @return bool
     * @throws TelegramException
     */
    public function deleteMyCommands(array $commands): bool
    {
        $response = $this->endpoint('setMyCommands', ['commands' => json_encode($commands, true)]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * UUse this method to get the current list of the bot's commands. Requires no parameters. Returns Array of BotCommand on success.
     * @see https://core.telegram.org/bots/api#getmycommands
     * @return BotCommand[]
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getMyCommands(array $parameters=[]): array
    {
        $response = $this->endpoint('getMyCommands', $parameters);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var BotCommand[] $object */
        $object = $this->mapper->mapArray($resultArray, [], BotCommand::class);

        return $object;
    }

    //endregion

    //region METHODS FOR THIRD-PARTY BOT API SERVER

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     * You must log out the bot before running it locally,
     * otherwise there is no guarantee that the bot will receive updates.
     * After a successful call, you can immediately log in on a local server,
     * but will not be able to log in back to the cloud Bot API server for 10 minutes.
     * Returns True on success. Requires no parameters.
     * @return bool
     * @throws TelegramException
     */
    public function logOut()
    {
        $response = $this->endpoint('logOut');

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     * You need to delete the webhook before calling this method to ensure that the
     * bot isn't launched again after server restart.
     * The method will return error 429 in the first 10 minutes after the bot is launched.
     * Returns True on success. Requires no parameters.
     * @return bool
     * @throws TelegramException
     */
    public function close()
    {
        $response = $this->endpoint('close');

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    //endregion

    //region UPDATING MESSAGES

    /**
     * Use this method to edit text and {@see https://core.telegram.org/bots/api#games game} messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param array $parameters
     * @return bool|Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function editMessageText(array $parameters)
    {
        $response = $this->endpoint('editMessageText', $parameters);

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
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param array $parameters
     * @return bool|Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function editMessageCaption(array $parameters)
    {
        $response = $this->endpoint('editMessageCaption', $parameters);

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
     * Use this method to edit animation, audio, document, photo, or video messages.
     * If a message is part of a message album, then it can be edited only to an audio for audio albums,
     * only to a document for document albums and to a photo or a video otherwise.
     * When an inline message is edited, a new file can't be uploaded.
     * Use a previously uploaded file via its file_id or specify a URL.
     * On success, if the edited message was sent by the bot,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagemedia
     * @param array $parameters
     * @return bool|Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function editMessageMedia(array $parameters)
    {
        $response = $this->endpoint('editMessageMedia', $parameters);

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
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param array $parameters
     * @return bool|Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function editMessageReplyMarkup(array $parameters)
    {
        $response = $this->endpoint('editMessageReplyMarkup', $parameters);

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
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped {@see https://core.telegram.org/bots/api#poll Poll} with the final results is returned.
     * @see https://core.telegram.org/bots/api#stoppoll
     * @param array $parameters
     * @return bool|Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function stopPoll(array $parameters)
    {
        $response = $this->endpoint('stopPoll', $parameters);

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
     * @param $chat_id    int|string Unique identifier for the target chat or username of the target channel (in the
     *                    format @channelusername)
     * @param $message_id int Identifier of the message to delete
     * @return bool
     * @throws TelegramException
     */
    public function deleteMessage($chat_id, int $message_id): bool
    {
        $response = $this->endpoint(
            'deleteMessage',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ]
        );

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    //endregion

    //region STICKERS

    /**
     * Use this method to send static .WEBP or
     * {@see https://telegram.org/blog/animated-stickers animated} .TGS stickers.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendsticker
     * @param array $parameters
     * @return Message
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function sendSticker(array $parameters): Message
    {
        $response = $this->endpoint('sendSticker', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to get a sticker set.
     * On success, a {@see https://core.telegram.org/bots/api#stickerset StickerSet} object is returned.
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param string $name Short name of the sticker set that is used in t.me/addstickers/ URLs (e.g., animals)
     * @return StickerSet
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getStickerSet(string $name): StickerSet
    {
        $response = $this->endpoint('getStickerSet', ['name' => $name]);

        /** @var StickerSet $object */
        $object = $this->mapper->map($response->result, new StickerSet());

        return $object;
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet and
     * addStickerToSet methods (can be used multiple times).
     * Returns the uploaded {@see https://core.telegram.org/bots/api#file File} on success.
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param int $user_id User identifier of sticker file owner
     * @param mixed $png_sticker [InputFile] Png image with the sticker, must be up to 512 kilobytes in size,
     *     dimensions must not exceed 512px, and either width or height must be exactly 512px.
     * @return File
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function uploadStickerFile(int $user_id, $png_sticker): File
    {
        $response = $this->endpoint('uploadStickerFile', ['user_id' => $user_id, 'png_sticker' => $png_sticker]);

        /** @var File $object */
        $object = $this->mapper->map($response->result, new File());

        return $object;
    }

    /**
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param array $parameters Parameters
     * @return bool
     * @throws TelegramException
     */
    public function createNewStickerSet(array $parameters): bool
    {
        $response = $this->endpoint('createNewStickerSet', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to add a new sticker to a set created by the bot.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Animated stickers can be added to animated sticker sets and only to them.
     * Animated sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers. Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param array $parameters Parameters
     * @return bool
     * @throws TelegramException
     */
    public function addStickerToSet(array $parameters): bool
    {
        $response = $this->endpoint('addStickerToSet', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
     * @return bool
     * @throws TelegramException
     */
    public function setStickerPositionInSet(string $sticker, int $position): bool
    {
        $response = $this->endpoint('setStickerPositionInSet', ['sticker' => $sticker, 'position' => $position]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param string $sticker File identifier of the sticker
     * @return bool
     * @throws TelegramException
     */
    public function deleteStickerFromSet(string $sticker): bool
    {
        $response = $this->endpoint('deleteStickerFromSet', ['sticker' => $sticker]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set the thumbnail of a sticker set.
     * Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumb
     * @param array $parameters Method parameters
     * @return bool
     * @throws TelegramException
     */
    public function setStickerSetThumb(array $parameters): bool
    {
        $response = $this->endpoint('setStickerSetThumb', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    //endregion

    //region INLINE MODE

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

    //endregion

    //region PAYMENTS

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

    //endregion

    //region TELEGRAM PASSPORT

    /**
     * Informs a user that some of the Telegram Passport elements they provided contains errors.
     * The user will not be able to re-submit their Passport to you until the errors are fixed
     * (the contents of the field for which you returned the error must change). Returns True on success.
     *
     * Use this if the data submitted by the user doesn't satisfy the standards your service requires for any reason.
     * For example, if a birthday date seems invalid, a submitted document is blurry,
     * a scan shows evidence of tampering, etc.
     * Supply some details in the error message to make sure the user knows how to correct the issues.
     * @see https://core.telegram.org/bots/api#setpassportdataerrors
     * @param $parameters
     * @return bool
     * @throws TelegramException
     */
    public function setPassportDataErrors($parameters): bool
    {
        $response = $this->endpoint('setPassportDataErrors', $parameters);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    //endregion

    //region GAMES

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
    public function setGameScore($parameters)
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

    //endregion

    //region UTILITIES

    /**
     * Download a file from Telegram Server
     * @param string $telegram_file_path
     * @param string $local_file_path
     */
    public function downloadFile(string $telegram_file_path, string $local_file_path): void
    {
        $telegramBotUrl = empty($this->botServerUrl) ? 'https://api.telegram.org/' : $this->botServerUrl;
        $file_url = "$telegramBotUrl/file/bot" .$this->token.'/'.$telegram_file_path;
        $in = fopen($file_url, 'rb');
        $out = fopen($local_file_path, 'wb');

        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    /**
     * Set a custom keyboard
     * @param array $options
     * @param bool $onetime
     * @param bool $resize
     * @param bool $selective
     * @return string
     */
    public function buildKeyBoard(array $options, $onetime = false, $resize = false, $selective = true): string
    {
        $replyMarkup = [
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective,
        ];

        return json_encode($replyMarkup, true);
    }

    /**
     * Set an InlineKeyBoard
     * @param array $options
     * @return string
     */
    public function buildInlineKeyBoard(array $options): string
    {
        $replyMarkup = [
            'inline_keyboard' => $options,
        ];

        return json_encode($replyMarkup, true);
    }

    /**
     * Create an InlineKeyboardButton
     * @param string $text
     * @param string $url
     * @param string $callback_data
     * @param string $switch_inline_query
     * @param string $switch_inline_query_current_chat
     * @param string $callback_game A placeholder, currently holds no information. Use BotFather to set up your game.
     * @param bool $pay Optional. Specify True, to send a Pay button. NOTE: This type of button must always be
     *                          the first button in the first row.
     * @return array
     */
    public function buildInlineKeyboardButton(
        string $text,
        $url = '',
        $callback_data = '',
        $switch_inline_query = '',
        $switch_inline_query_current_chat = '',
        $callback_game = '',
        $pay = false
    ): array {
        $replyMarkup = [
            'text' => $text,
        ];

        if ($url !== '') {
            $replyMarkup['url'] = $url;

            return $replyMarkup;
        }
        if ($callback_data !== '') {
            $replyMarkup['callback_data'] = $callback_data;

            return $replyMarkup;
        }
        if ($switch_inline_query !== '') {
            $replyMarkup['switch_inline_query'] = $switch_inline_query;

            return $replyMarkup;
        }
        if ($switch_inline_query_current_chat !== '') {
            $replyMarkup['switch_inline_query_current_chat'] = $switch_inline_query_current_chat;

            return $replyMarkup;
        }
        if ($callback_game !== '') {
            $replyMarkup['callback_game'] = $callback_game;

            return $replyMarkup;
        }
        if ($pay) {
            $replyMarkup['pay'] = true;

            return $replyMarkup;
        }

        return $replyMarkup;
    }

    /**
     * Create a KeyboardButton
     * @param string $text
     * @param bool $request_contact
     * @param bool $request_location
     * @return array
     */
    public function buildKeyboardButton(string $text, $request_contact = false, $request_location = false): array
    {
        return [
            'text' => $text,
            'request_contact' => $request_contact,
            'request_location' => $request_location,
        ];
    }

    /**
     * Hide a custom keyboard
     * @param bool $selective
     * @return string
     */
    public function buildKeyBoardHide($selective = true): string
    {
        $replyMarkup = [
            'remove_keyboard' => true,
            'selective' => $selective,
        ];

        return json_encode($replyMarkup, true);
    }

    /**
     * Display a reply interface to the user
     * @param bool $selective
     * @return string
     */
    public function buildForceReply($selective = true): string
    {
        $replyMarkup = [
            'force_reply' => true,
            'selective' => $selective,
        ];

        return json_encode($replyMarkup, true);
    }

    /**
     * A method for responding http to Telegram.
     * @return string return the HTTP 200 to Telegram
     */
    public function respondSuccess(): string
    {
        http_response_code(200);

        return json_encode(['status' => 'success']);
    }

    /**
     * Get Package version
     * @return string
     */
    public static function getFrameworkVersion(): string
    {
        $reflector = new ReflectionClass(__CLASS__);
        $vendorPath = preg_replace('/^(.*)\/composer\/ClassLoader\.php$/', '$1', $reflector->getFileName());
        $vendorPath = dirname($vendorPath, 2).DIRECTORY_SEPARATOR;
        $content = file_get_contents($vendorPath.'composer.json');
        $content = json_decode($content, true);

        return $content['version'];
    }

    //endregion

    //region OTHERS METHODS

    /**
     * Encode file
     * @param string $file
     * @return resource
     * @throws TelegramException
     */
    private function encodeFile(string $file)
    {
        $fp = fopen($file, 'rb');
        if ($fp === false) {
            throw new TelegramException('Cannot open "'.$file.'" for reading');
        }

        return $fp;
    }

    /**
     * Endpoint request
     * @param string $api API
     * @param array $parameters Parameters to send
     * @param bool $isPost Request method
     * @return Response
     * @throws TelegramException
     */
    public function endpoint(string $api, $parameters = [], $isPost = true): Response
    {
        $telegramBotUrl = empty($this->botServerUrl) ? 'https://api.telegram.org/' : $this->botServerUrl; 
        $response = $this->sendRequest(
            "$telegramBotUrl/bot" .$this->token.'/'.$api,
            $parameters,
            $isPost
        );
        $result = $response['result'];
        $body = $response['body'];
        //$info = $response['info'];
        $error = $response['error'];

        if (!$result && $error !== false) {
            throw new TelegramException("CURL request failed.\n".$error);
        }

        if (!is_json($body)) {
            throw new TelegramException('The response cannot be parsed to json.');
        }

        try {
            /** @var Response $data */
            $data = $this->mapper->map(json_decode($body, false), new Response());
        } catch (JsonMapper_Exception $e) {
            throw new TelegramException('The json cannot be mapped to object.');
        }

        if (!$data->ok) {
            throw new TelegramException($data->description, $data->error_code);
        }

        if ($data === null || $data->result === null) {
            throw new TelegramException('Response or Response result is null!');
        }

        return $data;
    }

    /**
     * Send a API request to Telegram
     * @param string $url Endpoint API
     * @param array $parameters Parameters to send
     * @param bool $isPost Request method. Allowed: GET, POST
     * @return array
     */
    private function sendRequest(string $url, array $parameters, bool $isPost): array
    {
        $request = curl_init();

        if (!$isPost) {
            if ($query = http_build_query($parameters)) {
                $url .= '?'.$query;
            }
        } else {
            curl_setopt($request, CURLOPT_POST, true);
            curl_setopt($request, CURLOPT_POSTFIELDS, $parameters);
        }

        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);

        $body = curl_exec($request);
        $info = curl_getinfo($request);
        $error = curl_error($request);

        curl_close($request);

        return [
            'result' => $body !== false,
            'body' => $body,
            'info' => $info,
            'error' => empty($error) ? false : $error,
        ];
    }

    //endregion
}
