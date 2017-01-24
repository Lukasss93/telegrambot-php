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
     * @param null|string $username Bot username
     */
    public function __construct($token)
    {
        //json mapper
        $this->mapper=new JsonMapper();
        $this->mapper->bStrictNullTypes = false;

        //telegram datas
        $this->token=$token;
        $this->webhookData = $this->getWebhookUpdate();
    }

    //<editor-fold desc="GETTING UPDATES">

    /**
     * Use this method to receive incoming updates using long polling (wiki). An Array of Update objects is returned.
     * Note: This method will not work if an outgoing webhook is set up.
     * @param array $parameters
     * @return Update[]
     */
    public function getUpdates($parameters)
    {
        $response = $this->endpoint("getUpdates", $parameters);

        /** @var array $response->result */
        $this->updatesData=$response===null?null:$this->mapper->mapArray($response->result,array(),'TelegramBot\Types\Update');

        if(count($this->updatesData) >= 1)
        {
            $last_element_id = $this->updatesData[count($this->updatesData) - 1]->update_id+1;
            $parameters = array('offset' => $last_element_id, 'limit' => "1", 'timeout' => 100);
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
     * 2. To use a self-signed certificate, you need to upload your public key certificate using certificate parameter. Please upload as InputFile, sending a String will not work.
     * 3. Ports currently supported for Webhooks: 443, 80, 88, 8443.
     * NEW! If you're having any trouble setting up webhooks,
     * please check out this amazing guide to Webhooks: https://core.telegram.org/bots/webhooks.
     *
     * @param array $parameters
     * @return bool
     */
    public function setWebhook($parameters)
    {
        if(isset($parameters['certificate']))
        {
            $parameters['certificate']=$this->encodeFile($parameters['certificate']);
        }

        $data=$this->endpoint('setWebhook',$parameters);
        $object=$data->result;

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
        $data=$this->endpoint('deleteWebhook',array());
        $object=$data->result;

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
        $data=$this->endpoint('getWebhookInfo',array());
        $object=$data->result===null?null:$this->mapper->map($data->result,new WebhookInfo());

        /** @var WebhookInfo $object */
        return $object;
    }

    /**
     * Incoming update from webhook
     * @return Update|null
     */
    public function getWebhookUpdate()
    {
        $current=null;

        if($this->webhookData===null)
        {
            $rawData = file_get_contents("php://input");
            $current=json_decode($rawData);

            $current = $current===null?null:$this->mapper->map($current, new Update());
        }
        else
        {
            $current=$this->webhookData;
        }

        /** @var Update|null $current */
        return $current;
    }

    //</editor-fold>

    //<editor-fold desc="AVAILABLE METHODS">

    /**
     * A simple method for testing your bot's auth token.
     * Requires no parameters.
     * Returns basic information about the bot in form of a User object.
     * @return User
     */
    public function getMe()
    {
        $data=$this->endpoint('getMe',array());
        $object=$this->mapper->map($data->result,new User());

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
        $data=$this->endpoint('sendMessage',$parameters);

        /** @var Message $object */
        $object=$this->mapper->map($data->result,new Message());
        return $object;
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned.
     * @param $parameters
     * @return Message
     */
    public function forwardMessage($parameters)
    {
        $response=$this->endpoint("forwardMessage", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     * @param $parameters
     * @return Message
     */
    public function sendPhoto($parameters)
    {
        $response=$this->endpoint("sendPhoto", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint("sendAudio", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint("sendDocument", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send .webp stickers. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendSticker($parameters)
    {
        $response=$this->endpoint("sendSticker", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint("sendVideo", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .ogg file encoded with OPUS
     * (other formats may be sent as Audio or Document). On success, the sent Message is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @param array $parameters
     * @return Message
     */
    public function sendVoice($parameters)
    {
        $response=$this->endpoint("sendVoice", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send point on the map. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendLocation($parameters)
    {
        $response=$this->endpoint("sendLocation", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send information about a venue. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendVenue($parameters)
    {
        $response=$this->endpoint("sendVenue", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method to send phone contacts. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendContact($parameters)
    {
        $response=$this->endpoint("sendContact", $parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
        return $object;
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).
     * Returns True on success.
     * Example: The ImageBot needs some time to process a request and upload the image.
     * Instead of sending a text message along the lines of “Retrieving image, please wait…”,
     * the bot may use sendChatAction with action = upload_photo.
     * The user will see a “sending photo” status for the bot.
     * We only recommend using this method when a response from the bot will take a noticeable amount of time to arrive.
     * @param int|string $chat_id
     * @param string $action
     * @return bool
     */
    public function sendChatAction($chat_id, $action)
    {
        $response=$this->endpoint("sendChatAction", array(
            'chat_id'=>$chat_id,
            'action'=>$action
        ));

        /** @var bool $object */
        $object=$response->result;
        return $object;
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     * @return UserProfilePhotos
     */
    public function getUserProfilePhotos($user_id, $offset=null, $limit=100)
    {
        $parameters=array(
            'user_id'=>$user_id,
            'limit'=>$limit
        );

        if($offset!==null){$parameters['offset']=$offset;}

        $response=$this->endpoint("getUserProfilePhotos", $parameters);

        /** @var UserProfilePhotos $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new UserProfilePhotos());
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
        $response=$this->endpoint("getFile", array('file_id' => $file_id));

        /** @var File $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new File());
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
     * @return bool
     */
    public function kickChatMember($chat_id, $user_id)
    {
        $response=$this->endpoint("kickChatMember", array(
            'chat_id'=>$chat_id,
            'user_id'=>$user_id
        ));

        /** @var bool $object */
        $object=$response->result;
        return $object;
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     * @param int|string $chat_id
     * @return bool
     */
    public function leaveChat($chat_id)
    {
        $response=$this->endpoint("leaveChat", array('chat_id'=>$chat_id));

        /** @var bool $object */
        $object=$response->result;
        return $object;
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup.
     * The user will not return to the group automatically, but will be able to join via link, etc.
     * The bot must be an administrator in the group for this to work.
     * Returns True on success.
     * @param int|string $chat_id
     * @param int $user_id
     * @return bool
     */
    public function unbanChatMember($chat_id, $user_id)
    {
        $response=$this->endpoint("unbanChatMember", array(
            'chat_id'=>$chat_id,
            'user_id'=>$user_id
        ));

        /** @var bool $object */
        $object=$response->result;
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
        $response=$this->endpoint("getChat", array('chat_id'=>$chat_id));

        /** @var Chat $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Chat());
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
        $response=$this->endpoint("getChatAdministrators", array('chat_id'=>$chat_id));

        /** @var array $response->result */
        $object=$response===null?null:$this->mapper->mapArray($response->result,array(),'TelegramBot\Types\ChatMember');

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
        $response=$this->endpoint("getChatMembersCount", array('chat_id'=>$chat_id));

        /** @var int $object */
        $object=$response->result;
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
        $response=$this->endpoint("getChatMember", array(
            'chat_id'=>$chat_id,
            'user_id'=>$user_id
        ));

        /** @var ChatMember $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new ChatMember());
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
        $data=$this->endpoint('answerCallbackQuery',$parameters);
        $object=$data->result;

        /** @var bool $object */
        return $object;
    }

    //</editor-fold>

    //<editor-fold desc="UPDATING MESSAGES">

    /**
     * Use this method to edit text and game messages sent by the bot or via the bot (for inline bots).
     * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
     * @param array $parameters
     * @return bool|Message
     */
    public function editMessageText($parameters)
    {
        $response=$this->endpoint("editMessageText", $parameters);

        if(is_bool($response->result))
        {
            /** @var bool $object */
            $object=$response->result;
            return $object;
        }
        else
        {
            /** @var Message $object */
            $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint("editMessageCaption", $parameters);

        if(is_bool($response->result))
        {
            /** @var bool $object */
            $object=$response->result;
            return $object;
        }
        else
        {
            /** @var Message $object */
            $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint("editMessageReplyMarkup", $parameters);

        if(is_bool($response->result))
        {
            /** @var bool $object */
            $object=$response->result;
            return $object;
        }
        else
        {
            /** @var Message $object */
            $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
            return $object;
        }
    }

    //</editor-fold>

    //<editor-fold desc="INLINE MODE">

    /**
     * Use this method to send answers to an inline query. On success, True is returned.
     * No more than 50 results per query are allowed.
     * @param array $parameters
     * @return bool
     */
    public function answerInlineQuery($parameters)
    {
        $response=$this->endpoint("answerInlineQuery", $parameters);

        /** @var bool $object */
        $object=$response->result;
        return $object;
    }

    //</editor-fold>

    //<editor-fold desc="GAMES">

    /**
     * Use this method to send a game. On success, the sent Message is returned.
     * @param array $parameters
     * @return Message
     */
    public function sendGame($parameters)
    {
        $response=$this->endpoint('sendGame',$parameters);

        /** @var Message $object */
        $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint('setGameScore',$parameters);

        if(is_bool($response->result))
        {
            /** @var bool $object */
            $object=$response->result;
            return $object;
        }
        else
        {
            /** @var Message $object */
            $object=$response->result===null?null:$this->mapper->map($response->result,new Message());
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
        $response=$this->endpoint('getGameHighScores',$parameters);

        /** @var array $response->result */
        $object=$response===null?null:$this->mapper->mapArray($response->result,array(),'TelegramBot\Types\GameHighScore');

        /** @var GameHighScore[] $object */
        return $object;
    }

    //</editor-fold>

    //<editor-fold desc="UTILITIES">

    /**
     * Download a file from Telegram Server
     * @param string $telegram_file_path
     * @param string $local_file_path
     */
    public function downloadFile($telegram_file_path, $local_file_path)
    {
        $file_url = "https://api.telegram.org/file/bot" . $this->token . "/" . $telegram_file_path;
        $in = fopen($file_url, "rb");
        $out = fopen($local_file_path, "wb");

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
        $replyMarkup = array(
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective
        );
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
        $replyMarkup = array(
            'inline_keyboard' => $options,
        );
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    /**
     * Create an InlineKeyboardButton
     * @param string $text
     * @param string $url
     * @param string $callback_data
     * @param string $switch_inline_query
     * @return array
     */
    public function buildInlineKeyboardButton($text, $url = '', $callback_data = '', $switch_inline_query = '')
    {
        $replyMarkup = array(
            'text' => $text
        );

        if($url != "")
        {
            $replyMarkup['url'] = $url;
        }
        else if($callback_data != '')
        {
            $replyMarkup['callback_data'] = $callback_data;
        }
        else if($switch_inline_query != '')
        {
            $replyMarkup['switch_inline_query'] = $switch_inline_query;
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
        $replyMarkup = array(
            'text' => $text,
            'request_contact' => $request_contact,
            'request_location' => $request_location
        );

        return $replyMarkup;
    }

    /**
     * Hide a custom keyboard
     * @param bool $selective
     * @return string
     */
    public function buildKeyBoardHide($selective = true)
    {
        $replyMarkup = array(
            'hide_keyboard' => true,
            'selective' => $selective
        );
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
        $replyMarkup = array(
            'force_reply' => true,
            'selective' => $selective
        );
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    //</editor-fold>

    //<editor-fold desc="PRIVATE METHODS">

    /**
     * Endpoint request
     * @param string $api API
     * @param array $content Parameteres to send
     * @param bool $post Request method
     * @return Response
     * @throws Exception
     */
    public function endpoint($api, array $content, $post = true)
    {
        $url = 'https://api.telegram.org/bot' . $this->token . '/' . $api;

        if ($post)
        {
            $reply = $this->sendRequest($url, $content);
        }
        else
        {
            $reply = $this->sendRequest($url, array(), false);
        }

        if($reply===false)
        {
            throw new TelegramException('Server offline.');
        }

        if(!Tools::isJSON($reply))
        {
            throw new TelegramException('The response cannot be parsed to json.');
        }

        /** @var Response $data */
        $data=json_decode($reply);

        if(!$data->ok)
        {
            throw new TelegramException($data->description,$data->error_code);
        }

        return $data;
    }

    /**
     * Send a API request to Telegram
     * @param string $url Endpoint API
     * @param array $content Parameters to send
     * @param bool $post Request method. Allowed: GET, POST
     * @return string
     */
    private function sendRequest($url, array $content, $post = true)
    {
        /*
        if (isset($content['chat_id']))
        {
            $url = $url . "?chat_id=" . $content['chat_id'];
            unset($content['chat_id']);
        }*/

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.Tools::parametersToString($content));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post)
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
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
        if ($fp === false)
        {
            throw new TelegramException('Cannot open "' . $file . '" for reading');
        }
        return $fp;
    }

    //</editor-fold>
}