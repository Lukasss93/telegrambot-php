<?php

namespace TelegramBot;

use AuraX\Tools;
use Exception;
use JsonMapper;
use TelegramBot\Types\Chat;
use TelegramBot\Types\ChatMember;
use TelegramBot\Types\File;
use TelegramBot\Types\GameHighScore;
use TelegramBot\Types\Message;
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
    /** @var JsonMapper */
    private $mapper;

    /** @var string Bot token */
    private $token;

    /** @var Update Webhook update */
    public $webhookData;

    /** @var Update[] GetUpdates data */
    public $updatesData;

    /**
     * TelegramBot constructor.
     * @param string $token Bot token
     * @param string[] $config Configuration array
     * @throws TelegramException $config variable must be an array!
     */
    public function __construct($token)
    {
        //json mapper
        $this->mapper = new JsonMapper();
        $this->mapper->bStrictNullTypes = false;

        //telegram datas
        $this->token = $token;
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
     * @param bool $update If true updates the pending message list to the last update received. Default to true.
     * @return Update[]
     */
    public function getUpdates($offset = 0, $limit = 100, $timeout = 0, $update = true)
    {
        $parameters = ['offset' => $offset, 'limit' => $limit, 'timeout' => $timeout];
        $response = $this->endpoint("getUpdates", $parameters);

        /** @var array $updates */
        $updates = $response->result;

        $this->updatesData = $this->mapper->mapArray($updates, [], 'TelegramBot\Types\Update');

        if (count($this->updatesData) >= 1) {
            $last_element_id = $this->updatesData[count($this->updatesData) - 1]->update_id + 1;
            $parameters = ['offset' => $last_element_id, 'limit' => "1", 'timeout' => 100];
            $this->endpoint("getUpdates", $parameters);
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
     */
    public function setWebhook($parameters)
    {
        if (isset($parameters['certificate'])) {
            $parameters['certificate'] = $this->encodeFile($parameters['certificate']);
        }

        $data = $this->endpoint('setWebhook', $parameters);
        $object = $data->result;

        /** @var bool $object */
        return $object;
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates.
     * Returns True on success. Requires no parameters.
     * @return bool
     */
    public function deleteWebhook()
    {
        $data = $this->endpoint('deleteWebhook', []);
        $object = $data->result;

        /** @var bool $object */
        return $object;
    }

    /**
     * Use this method to get current webhook status.
     * Requires no parameters.
     * On success, returns a WebhookInfo object.
     * If the bot is using getUpdates, will return an object with the url field empty.
     * @return WebhookInfo
     */
    public function getWebhookInfo()
    {
        $data = $this->endpoint('getWebhookInfo', [], false);
        $object = $this->mapper->map($data->result, new WebhookInfo());

        /** @var WebhookInfo $object */
        return $object;
    }

    /**
     * Incoming update from webhook
     * @return Update|null
     */
    public function getWebhookUpdate()
    {
        $current = null;

        if ($this->webhookData === null) {
            $rawData = file_get_contents("php://input");
            $current = json_decode($rawData);

            $current = $current === null ? null : $this->mapper->map($current, new Update());
        } else {
            $current = $this->webhookData;
        }

        /** @var Update|null $current */
        return $current;
    }

    //endregion

    //region AVAILABLE METHODS

    /**
     * A simple method for testing your bot's auth token.
     * Requires no parameters.
     * Returns basic information about the bot in form of a User object.
     * @return User
     */
    public function getMe()
    {
        $data = $this->endpoint('getMe', [], false);
        $object = $this->mapper->map($data->result, new User());

        /** @var User $object */
        return $object;
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendMessage($parameters)
    {
        $data = $this->endpoint('sendMessage', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());
        return $object;
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned.
     * @param $parameters
     * @return Message
     */
    public function forwardMessage($parameters)
    {
        $response = $this->endpoint("forwardMessage", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     * @param $parameters
     * @return Message
     */
    public function sendPhoto($parameters)
    {
        $response = $this->endpoint("sendPhoto", $parameters);

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
     */
    public function sendAudio($parameters)
    {
        $response = $this->endpoint("sendAudio", $parameters);

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
     */
    public function sendDocument($parameters)
    {
        $response = $this->endpoint("sendDocument", $parameters);

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
     */
    public function sendVideo($parameters)
    {
        $response = $this->endpoint("sendVideo", $parameters);

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
     */
    public function sendVoice($parameters)
    {
        $response = $this->endpoint("sendVoice", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendVideoNote($parameters)
    {
        $response = $this->endpoint("sendVideoNote", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to send point on the map. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendLocation($parameters)
    {
        $response = $this->endpoint("sendLocation", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to send information about a venue. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendVenue($parameters)
    {
        $response = $this->endpoint("sendVenue", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to send phone contacts. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendContact($parameters)
    {
        $response = $this->endpoint("sendContact", $parameters);

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
     */
    public function sendChatAction($chat_id, $action)
    {
        $response = $this->endpoint("sendChatAction", ['chat_id' => $chat_id, 'action' => $action]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     * @return UserProfilePhotos
     */
    public function getUserProfilePhotos($user_id, $offset = null, $limit = 100)
    {
        $parameters = [
            'user_id' => $user_id,
            'limit' => $limit
        ];

        if ($offset !== null) {
            $parameters['offset'] = $offset;
        }

        $response = $this->endpoint("getUserProfilePhotos", $parameters);

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
     */
    public function getFile($file_id)
    {
        $response = $this->endpoint("getFile", ['file_id' => $file_id]);

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
     * @param int $until_date Date when the user will be unbanned, unix time.
     *                               If user is banned for more than 366 days or less than 30 seconds
     *                               from the current time they are considered to be banned forever
     * @return bool
     */
    public function kickChatMember($chat_id, $user_id, $until_date = null)
    {
        $options = [
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ];

        if ($until_date !== null) {
            $options['until_date'] = $until_date;
        }

        $response = $this->endpoint("kickChatMember", $options);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup.
     * The user will not return to the group automatically, but will be able to join via link, etc.
     * The bot must be an administrator in the group for this to work.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @param int $user_id
     * @return bool
     */
    public function unbanChatMember($chat_id, $user_id)
    {
        $response = $this->endpoint("unbanChatMember", [
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup
     * for this to work and must have the appropriate admin rights.
     * Pass True for all boolean parameters to lift restrictions from a user. Returns True on success.
     * @param array $parameters
     * @return bool
     */
    public function restrictChatMember($parameters)
    {
        $response = $this->endpoint("restrictChatMember", $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     * @param array $parameters
     * @return bool
     */
    public function promoteChatMember($parameters)
    {
        $response = $this->endpoint("promoteChatMember", $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to export an invite link to a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns exported invite link as String on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                            format @channelusername)
     * @return string
     */
    public function exportChatInviteLink($chat_id)
    {
        $response = $this->endpoint("exportChatInviteLink", [
            'chat_id' => $chat_id,
        ]);

        /** @var string $object */
        $object = $response->result;
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
     * @param InputFile $photo New chat photo, uploaded using multipart/form-data
     * @return bool
     */
    public function setChatPhoto($chat_id, $photo)
    {
        $response = $this->endpoint("setChatPhoto", [
            'chat_id' => $chat_id,
            'photo' => $photo
        ]);

        /** @var bool $object */
        $object = $response->result;
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
     */
    public function deleteChatPhoto($chat_id)
    {
        $response = $this->endpoint("deleteChatPhoto", [
            'chat_id' => $chat_id
        ]);

        /** @var bool $object */
        $object = $response->result;
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
     */
    public function setChatTitle($chat_id, $title)
    {
        $response = $this->endpoint("setChatTitle", [
            'chat_id' => $chat_id,
            'title' => $title
        ]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to change the description of a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must
     * have the appropriate admin rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the
     *                                format @channelusername)
     * @param string $description New chat description, 0-255 characters
     * @return bool
     */
    public function setChatDescription($chat_id, $description = null)
    {
        $options = ['chat_id' => $chat_id];

        if ($description !== null) {
            $options['description'] = $description;
        }

        $response = $this->endpoint("setChatDescription", $options);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to pin a message in a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target
     *                                         supergroup (in the format @supergroupusername)
     * @param int $message_id Identifier of a message to pin
     * @param bool $disable_notification Pass true, if it is not necessary to send a notification to all group
     *                                         members about the new pinned message
     * @return bool
     */
    public function pinChatMessage($chat_id, $message_id, $disable_notification = false)
    {
        $options = [
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ];

        if ($disable_notification) {
            $options['disable_notification'] = true;
        }

        $response = $this->endpoint("pinChatMessage", $options);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to unpin a message in a supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *                            format @supergroupusername)
     * @return bool
     */
    public function unpinChatMessage($chat_id)
    {
        $response = $this->endpoint("unpinChatMessage", ['chat_id' => $chat_id,]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     * @param int|string $chat_id
     * @return bool
     */
    public function leaveChat($chat_id)
    {
        $response = $this->endpoint("leaveChat", ['chat_id' => $chat_id]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to get up to date information about the chat
     * (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a Chat object on success.
     * @param int|string $chat_id
     * @return Chat
     */
    public function getChat($chat_id)
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
     */
    public function getChatAdministrators($chat_id)
    {
        $response = $this->endpoint('getChatAdministrators', ['chat_id' => $chat_id], false);

        /** @var array $response ->result */
        $object = $this->mapper->mapArray($response->result, [], 'TelegramBot\Types\ChatMember');

        /** @var ChatMember[] $object */
        return $object;
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     * @param int|string $chat_id
     * @return int
     */
    public function getChatMembersCount($chat_id)
    {
        $response = $this->endpoint('getChatMembersCount', ['chat_id' => $chat_id], false);

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
     */
    public function getChatMember($chat_id, $user_id)
    {
        $response = $this->endpoint('getChatMember', [
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ], false);

        /** @var ChatMember $object */
        $object = $this->mapper->map($response->result, new ChatMember());
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
     */
    public function answerCallbackQuery($parameters)
    {
        $data = $this->endpoint('answerCallbackQuery', $parameters);

        /** @var bool $object */
        $object = $data->result;

        return $object;
    }

    //endregion

    //region UPDATING MESSAGES

    /**
     * Use this method to edit text and game messages sent by the bot or via the bot (for inline bots).
     * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
     * @param array $parameters
     * @return bool|Message
     */
    public function editMessageText($parameters)
    {
        $response = $this->endpoint('editMessageText', $parameters);

        if (is_bool($response->result)) {
            /** @var bool $object */
            $object = $response->result;
            return $object;
        } else {
            /** @var Message $object */
            $object = $this->mapper->map($response->result, new Message());
            return $object;
        }
    }

    /**
     * Use this method to edit captions of messages sent by the bot or via the bot (for inline bots).
     * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
     * @param array $parameters
     * @return bool|Message
     */
    public function editMessageCaption($parameters)
    {
        $response = $this->endpoint('editMessageCaption', $parameters);

        if (is_bool($response->result)) {
            /** @var bool $object */
            $object = $response->result;
            return $object;
        } else {
            /** @var Message $object */
            $object = $this->mapper->map($response->result, new Message());
            return $object;
        }
    }

    /**
     * Use this method to edit only the reply markup of messages sent by the bot or via the bot (for inline bots).
     * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
     * @param array $parameters
     * @return bool|Message
     */
    public function editMessageReplyMarkup($parameters)
    {
        $response = $this->endpoint('editMessageReplyMarkup', $parameters);

        if (is_bool($response->result)) {
            /** @var bool $object */
            $object = $response->result;
            return $object;
        } else {
            /** @var Message $object */
            $object = $this->mapper->map($response->result, new Message());
            return $object;
        }
    }

    /**
     * Use this method to delete a message. A message can only be deleted if it was sent less than 48 hours ago.
     * Any such recently sent outgoing message may be deleted. Additionally, if the bot is an administrator in a
     * group chat, it can delete any message.
     * If the bot is an administrator in a supergroup, it can delete messages from any other user
     * and service messages about people joining or leaving the group (other types of service messages may
     * only be removed by the group creator).
     * In channels, bots can only remove their own messages. Returns True on success.
     * @param $chat_id    int|string Unique identifier for the target chat or username of the target channel (in the
     *                    format @channelusername)
     * @param $message_id int Identifier of the message to delete
     * @return bool
     */
    public function deleteMessage($chat_id, $message_id)
    {
        $response = $this->endpoint('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    //endregion

    //region STICKERS

    /**
     * Use this method to send .webp stickers. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendSticker($parameters)
    {
        $response = $this->endpoint("sendSticker", $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to get a sticker set. On success, a StickerSet object is returned.
     * @param string $name Short name of the sticker set that is used in t.me/addstickers/ URLs (e.g., animals)
     * @return StickerSet
     */
    public function getStickerSet($name)
    {
        $response = $this->endpoint("getStickerSet", ['name' => $name]);

        /** @var StickerSet $object */
        $object = $this->mapper->map($response->result, new StickerSet());
        return $object;
    }

    /**
     * Use this method to upload a .png file with a sticker for later use in createNewStickerSet
     * and addStickerToSet methods (can be used multiple times). Returns the uploaded File on success.
     * @param int $user_id User identifier of sticker file owner
     * @param InputFile $png_sticker Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px.
     * @return File
     */
    public function uploadStickerFile($user_id, $png_sticker)
    {
        $response = $this->endpoint("getStickerSet", ['user_id' => $user_id, 'png_sticker' => $png_sticker]);

        /** @var File $object */
        $object = $this->mapper->map($response->result, new File());
        return $object;
    }

    /**
     * Use this method to create new sticker set owned by a user. The bot will be able to edit the created sticker set. Returns True on success.
     * @param array $parameters Parameters
     * @return bool
     */
    public function createNewStickerSet($parameters)
    {
        $response = $this->endpoint("createNewStickerSet", $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to add a new sticker to a set created by the bot. Returns True on success.
     * @param array $parameters Parameters
     * @return bool
     */
    public function addStickerToSet($parameters)
    {
        $response = $this->endpoint("addStickerToSet", $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position . Returns True on success.
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
     * @return bool
     */
    public function setStickerPositionInSet($sticker, $position)
    {
        $response = $this->endpoint("setStickerPositionInSet", ['sticker' => $sticker, 'position' => $position]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     * @param string $sticker File identifier of the sticker
     * @return bool
     */
    public function deleteStickerFromSet($sticker)
    {
        $response = $this->endpoint("deleteStickerFromSet", ['sticker' => $sticker]);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    //endregion

    //region INLINE MODE

    /**
     * Use this method to send answers to an inline query. On success, True is returned.
     * No more than 50 results per query are allowed.
     * @param array $parameters
     * @return bool
     */
    public function answerInlineQuery($parameters)
    {
        $response = $this->endpoint('answerInlineQuery', $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    //endregion

    //region PAYMENTS
    /**
     * Your bot can accept payments from Telegram users.
     * Please see the introduction to payments for more details
     * on the process and how to set up payments for your bot.
     * Please note that users will need Telegram v.4.0 or
     * higher to use payments (released on May 18, 2017).
     */

    /**
     * Use this method to send invoices.
     * On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendInvoice($parameters)
    {
        $data = $this->endpoint('sendInvoice', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());
        return $object;
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter
     * is_flexible was specified, the Bot API will send an Update with a
     * shipping_query field to the bot.
     * Use this method to reply to shipping queries.
     * On success, True is returned.
     * @param object[] $parameters
     * @return bool
     */
    public function answerShippingQuery($parameters)
    {
        $response = $this->endpoint('answerShippingQuery', $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    /**
     * Once the user has confirmed their payment and shipping details,
     * the Bot API sends the final confirmation in the form of an Update
     * with the field pre_checkout_query.
     * Use this method to respond to such pre-checkout queries.
     * On success, True is returned.
     * Note: The Bot API must receive an answer within 10 seconds
     * after the pre-checkout query was sent.
     * @param object[] $parameters
     * @return bool
     */
    public function answerPreCheckoutQuery($parameters)
    {
        $response = $this->endpoint('answerPreCheckoutQuery', $parameters);

        /** @var bool $object */
        $object = $response->result;
        return $object;
    }

    //endregion

    //region GAMES

    /**
     * Use this method to send a game. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendGame($parameters)
    {
        $response = $this->endpoint('sendGame', $parameters);

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());
        return $object;
    }

    /**
     * Use this method to set the score of the specified user in a game.
     * On success, if the message was sent by the bot, returns the edited Message, otherwise returns True.
     * Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
     * @param $parameters
     * @return bool|Message
     */
    public function setGameScore($parameters)
    {
        $response = $this->endpoint('setGameScore', $parameters);

        if (is_bool($response->result)) {
            /** @var bool $object */
            $object = $response->result;
            return $object;
        } else {
            /** @var Message $object */
            $object = $this->mapper->map($response->result, new Message());
            return $object;
        }
    }

    /**
     * Use this method to get data for high score tables.
     * Will return the score of the specified user and several of his neighbors in a game.
     * On success, returns an Array of GameHighScore objects.
     * This method will currently return scores for the target user, plus two of his closest neighbors on each side.
     * Will also return the top three users if the user and his neighbors are not among them.
     * Please note that this behavior is subject to change.
     * @param array $parameters
     * @return GameHighScore[]
     */
    public function getGameHighScores($parameters)
    {
        $response = $this->endpoint('getGameHighScores', $parameters, false);

        /** @var array $response ->result */
        $object = $this->mapper->mapArray($response->result, [], 'TelegramBot\Types\GameHighScore');

        /** @var GameHighScore[] $object */
        return $object;
    }

    //endregion

    //region UTILITIES

    /**
     * Download a file from Telegram Server
     * @param string $telegram_file_path
     * @param string $local_file_path
     */
    public function downloadFile($telegram_file_path, $local_file_path)
    {
        $file_url = 'https://api.telegram.org/file/bot' . $this->token . '/' . $telegram_file_path;
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
    public function buildKeyBoard($options, $onetime = false, $resize = false, $selective = true)
    {
        $replyMarkup = [
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective
        ];
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    /**
     * Set an InlineKeyBoard
     * @param array $options
     * @return string
     */
    public function buildInlineKeyBoard($options)
    {
        $replyMarkup = [
            'inline_keyboard' => $options,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    /**
     * Create an InlineKeyboardButton
     * @param string $text
     * @param string $url
     * @param string $callback_data
     * @param string $switch_inline_query
     * @param string $switch_inline_query_current_chat
     * @param CallbackGame $callback_game
     * @param bool $pay Optional. Specify True, to send a Pay button. NOTE: This type of button must always be
     *                          the first button in the first row.
     * @return array
     */
    public function buildInlineKeyboardButton($text, $url = '', $callback_data = '', $switch_inline_query = '', $switch_inline_query_current_chat = '', $callback_game = '', $pay = false)
    {
        $replyMarkup = [
            'text' => $text
        ];

        if ($url != '') {
            $replyMarkup['url'] = $url;
        } else if ($callback_data != '') {
            $replyMarkup['callback_data'] = $callback_data;
        } else if ($switch_inline_query != '') {
            $replyMarkup['switch_inline_query'] = $switch_inline_query;
        } else if ($switch_inline_query_current_chat != '') {
            $replyMarkup['switch_inline_query_current_chat'] = $switch_inline_query_current_chat;
        } else if ($callback_game != '') {
            $replyMarkup['callback_game'] = $callback_game;
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
    public function buildKeyboardButton($text, $request_contact = false, $request_location = false)
    {
        $replyMarkup = [
            'text' => $text,
            'request_contact' => $request_contact,
            'request_location' => $request_location
        ];

        return $replyMarkup;
    }

    /**
     * Hide a custom keyboard
     * @param bool $selective
     * @return string
     */
    public function buildKeyBoardHide($selective = true)
    {
        $replyMarkup = [
            'remove_keyboard' => true,
            'selective' => $selective
        ];
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    /**
     * Display a reply interface to the user
     * @param bool $selective
     * @return string
     */
    public function buildForceReply($selective = true)
    {
        $replyMarkup = [
            'force_reply' => true,
            'selective' => $selective
        ];
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    /**
     * A method for responding http to Telegram.
     * @return string return the HTTP 200 to Telegram
     */
    public function respondSuccess()
    {
        http_response_code(200);
        return json_encode(['status' => 'success']);
    }

    /**
     * Get Package version
     * @return string
     */
    public static function getFrameworkVersion()
    {
        $reflector = new \ReflectionClass(TelegramBot::class);
        $vendorPath = preg_replace('/^(.*)\/composer\/ClassLoader\.php$/', '$1', $reflector->getFileName());
        $vendorPath = dirname(dirname($vendorPath)) . DIRECTORY_SEPARATOR;
        $content = file_get_contents($vendorPath . 'composer.json');
        $content = json_decode($content, true);
        return $content['version'];
    }

    //endregion

    //region PRIVATE METHODS

    /**
     * Endpoint request
     * @param string $api API
     * @param array $content Parameteres to send
     * @param bool $isPost Request method
     * @return Response
     * @throws Exception
     */
    private function endpoint($api, array $content, $isPost = true)
    {
        $response = $this->sendRequest('https://api.telegram.org/bot' . $this->token . '/' . $api, $content, $isPost);
        $result = $response['result'];
        $body = $response['body'];
        $info = $response['info'];
        $error = $response['error'];

        if (!$result && $error != false) {
            throw new TelegramException("CURL request failed.\n" + $error);
        }

        if (!Tools::isJSON($body)) {
            throw new TelegramException('The response cannot be parsed to json.');
        }

        /** @var Response $data */
        $data = $this->mapper->map(json_decode($body), new Response());

        if (!$data->ok) {
            throw new TelegramException($data->description, $data->error_code);
        }

        if (is_null($data) || is_null($data->result)) {
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
    private function sendRequest($url, array $parameters, $isPost)
    {
        $request = curl_init();

        if (!$isPost) {
            if ($query = http_build_query($parameters)) {
                $url .= '?' . $query;
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
            'result' => $body === false ? false : true,
            'body' => $body,
            'info' => $info,
            'error' => empty($error) ? false : $error
        ];
    }

    /**
     * Encode file
     * @param string $file
     * @return resource
     * @throws TelegramException
     */
    private function encodeFile($file)
    {
        $fp = fopen($file, 'r');
        if ($fp === false) {
            throw new TelegramException('Cannot open "' . $file . '" for reading');
        }
        return $fp;
    }

    //endregion
}

/** Helper for Uploading file using CURL */
if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mimetype = '', $postname = '')
    {
        return "@$filename;filename=" . ($postname ?: basename($filename)) . ($mimetype ? ";type=$mimetype" : '');
    }
}

/** Helper for Uploading file using CURL with auto mime */
function curl_file_create_auto_mime($filename, $postname = '')
{
    return curl_file_create($filename, '', $postname);
}