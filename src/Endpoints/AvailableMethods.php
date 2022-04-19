<?php

namespace TelegramBot\Endpoints;

use JsonException;
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
     * Returns basic information about the bot in form of a {@see https://core.telegram.org/bots/api#user User} object.
     * @see https://core.telegram.org/bots/api#getme
     * @return User
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getMe(): User
    {
        $data = $this->endpoint(__FUNCTION__, isPost: false);
        $object = $this->mapper->map($data->result, new User());

        /** @var User $object */
        return $object;
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     * You must log out the bot before running it locally,
     * otherwise there is no guarantee that the bot will receive updates.
     * After a successful call, you can immediately log in on a local server,
     * but will not be able to log in back to the cloud Bot API server for 10 minutes.
     * Returns True on success. Requires no parameters.
     * @see https://core.telegram.org/bots/api#logout
     * @return bool
     * @throws TelegramException
     */
    public function logOut(): bool
    {
        $response = $this->endpoint(__FUNCTION__);

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
     * @see https://core.telegram.org/bots/api#close
     * @return bool
     * @throws TelegramException
     */
    public function close(): bool
    {
        $response = $this->endpoint(__FUNCTION__);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * If splitLongMessage property is true, Messages[] is returned.
     * @see https://core.telegram.org/bots/api#sendmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param array $opt Optional parameters
     * @return Message|Message[]
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendMessage(int|string $chat_id, string $text, array $opt = []): Message|array
    {
        $params = array_merge(['chat_id' => $chat_id, 'text' => $text], $opt);

        if ($this->splitLongMessage) {
            if (!isset($params['text'])) {
                throw new TelegramException('text parameter not set.');
            }

            /** @var Message[] $messagesResponse */
            $messagesResponse = [];
            $messages = mb_str_split($params['text'], 4096);

            foreach ($messages as $message) {
                $params['text'] = $message;
                $data = $this->endpoint(__FUNCTION__, $params);

                /** @var Message $object */
                $object = $this->mapper->map($data->result, new Message());
                $messagesResponse[] = $object;
            }

            return $messagesResponse;
        }

        $data = $this->endpoint(__FUNCTION__, $params);

        /** @var Message $object */
        $object = $this->mapper->map($data->result, new Message());

        return $object;
    }

    /**
     * Use this method to forward messages of any kind.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#forwardmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function forwardMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        array $opt = [],
    ): Message {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'from_chat_id' => $from_chat_id,
            'message_id' => $message_id,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to copy messages of any kind.
     * The method is analogous to the method {@see https://core.telegram.org/bots/api#forwardmessage forwardMessage},
     * but the copied message doesn't have a link to the original message.
     * Returns the {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent message on success.
     * @see https://core.telegram.org/bots/api#copymessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param array $opt Optional parameters
     * @return MessageId
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function copyMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        array $opt = [],
    ): MessageId {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'from_chat_id' => $from_chat_id,
            'message_id' => $message_id,
        ], $opt));

        /** @var MessageId $object */
        $object = $this->mapper->map($response->result, new MessageId());

        return $object;
    }

    /**
     * Use this method to send photos.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendphoto
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $photo Photo to send.
     * Pass a file_id as String to send a photo that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get a photo from the Internet,
     * or upload a new photo using multipart/form-data. The photo must be at most 10 MB in size.
     * The photo's width and height must not exceed 10000 in total. Width and height ratio must be at most 20.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendPhoto(int|string $chat_id, mixed $photo, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'photo' => $photo,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .mp3 format.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     * For sending voice messages, use the {@see https://core.telegram.org/bots/api#sendvoice sendVoice} method instead.
     * @see https://core.telegram.org/bots/api#sendaudio
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $audio Audio file to send.
     * Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get an audio file from the Internet,
     * or upload a new one using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendAudio(int|string $chat_id, mixed $audio, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'audio' => $audio,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send general files.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#senddocument
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $document File to send.
     * Pass a file_id as String to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get a file from the Internet,
     * or upload a new one using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendDocument(int|string $chat_id, mixed $document, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'document' => $document,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos
     * (other formats may be sent as {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvideo
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $video Video to send.
     * Pass a file_id as String to send a video that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get a video from the Internet,
     * or upload a new video using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendVideo(int|string $chat_id, mixed $video, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'video' => $video,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendanimation
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $animation Animation to send.
     * Pass a file_id as String to send an animation that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get an animation from the Internet,
     * or upload a new animation using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendAnimation(int|string $chat_id, mixed $animation, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'animation' => $animation,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice
     * message. For this to work, your audio must be in an .ogg file encoded with OPUS (other formats may be sent as
     * {@see https://core.telegram.org/bots/api#audio Audio} or
     * {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvoice
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $voice Audio file to send.
     * Pass a file_id as String to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL as a String for Telegram to get a file from the Internet,
     * or upload a new one using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendVoice(int|string $chat_id, mixed $voice, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'voice' => $voice,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * As of {@see https://telegram.org/blog/video-messages-and-telescope v.4.0},
     * Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvideonote
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $video_note Video note to send.
     * Pass a file_id as String to send a video note that exists on the Telegram servers (recommended)
     * or upload a new video using multipart/form-data.
     * {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}.
     * Sending video notes by a URL is currently unsupported
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendVideoNote(int|string $chat_id, mixed $video_note, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'video_note' => $video_note,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album.
     * Documents and audio files can be only group in an album with messages of the same type.
     * On success, an array of {@see https://core.telegram.org/bots/api#message Messages} that were sent is returned.
     * @see https://core.telegram.org/bots/api#sendmediagroup
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param array $media An array describing messages to be sent, must include 2-10 items
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonException
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendMediaGroup(int|string $chat_id, array $media, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'media' => json_encode($media, JSON_THROW_ON_ERROR),
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send point on the map.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendlocation
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param float $latitude Latitude of the location
     * @param float $longitude Longitude of the location
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendLocation(int|string $chat_id, float $latitude, float $longitude, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to edit live location messages sent by the bot or via the bot (for inline bots).
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to
     * {@see https://core.telegram.org/bots/api#stopmessagelivelocation stopMessageLiveLocation}.
     * On success, if the edited message was sent by the bot,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned,
     * otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     * @param float $latitude Latitude of new location
     * @param float $longitude Longitude of new location
     * @param array $opt Optional parameters
     * @return Message|bool
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function editMessageLiveLocation(float $latitude, float $longitude, array $opt = []): Message|bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ], $opt));

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
     * live_period expires. On success, if the message was sent by the bot,
     * the sent {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     * @param array $opt Optional parameters
     * @return Message|bool
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function stopMessageLiveLocation(array $opt = []): Message|bool
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

        if (is_bool($response->result)) {
            $object = $response->result;
        } else {
            $object = $this->mapper->map($response->result, new Message());
        }

        /** @var Message|bool $object */
        return $object;
    }

    /**
     * Use this method to send information about a venue.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvenue
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param float $latitude Latitude of the venue
     * @param float $longitude Longitude of the venue
     * @param string $title Name of the venue
     * @param string $address Address of the venue
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendVenue(
        int|string $chat_id,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        array $opt = [],
    ): Message {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'title' => $title,
            'address' => $address,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send phone contacts.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendcontact
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $phone_number Contact's phone number
     * @param string $first_name Contact's first name
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendContact(int|string $chat_id, string $phone_number, string $first_name, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'phone_number' => $phone_number,
            'first_name' => $first_name,
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send a native poll.
     * A native poll can't be sent to a private chat.
     * On success, the sent Message is returned.
     * @see https://core.telegram.org/bots/api#sendpoll
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $question Poll question, 1-300 characters
     * @param array $options A list of answer options, 2-10 strings 1-100 characters each
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     * @throws JsonException
     */
    public function sendPoll(int|string $chat_id, string $question, array $options, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'question' => $question,
            'options' => json_encode($options, JSON_THROW_ON_ERROR),
        ], $opt));

        /** @var Message $object */
        $object = $this->mapper->map($response->result, new Message());

        return $object;
    }

    /**
     * Use this method to send an animated emoji that will display a random value.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#senddice
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param array $opt Optional parameters
     * @return Message
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function sendDice(int|string $chat_id, array $opt = []): Message
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
        ], $opt));

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
     * @see https://core.telegram.org/bots/api#sendchataction
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
    public function sendChatAction(int|string $chat_id, string $action): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'action' => $action,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get a list of profile pictures for a user.
     * Returns a {@see https://core.telegram.org/bots/api#userprofilephotos UserProfilePhotos} object.
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     * @param int $user_id Unique identifier of the target user
     * @param array $opt Optional parameters
     * @return UserProfilePhotos
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getUserProfilePhotos(int $user_id, array $opt = []): UserProfilePhotos
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'user_id' => $user_id,
        ], $opt));

        /** @var UserProfilePhotos $object */
        $object = $this->mapper->map($response->result, new UserProfilePhotos());

        return $object;
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size.
     * On success, a {@see https://core.telegram.org/bots/api#file File} object is returned.
     * The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>,
     * where <file_path> is taken from the response.
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by
     * calling {@see https://core.telegram.org/bots/api#getfile getFile} again.
     *
     * Note: This function may not preserve the original file name and MIME type.
     * You should save the file's MIME type and name (if available) when the File object is received.
     * @see https://core.telegram.org/bots/api#getfile
     * @param string $file_id File identifier to get info about
     * @return File
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getFile(string $file_id): File
    {
        $response = $this->endpoint(__FUNCTION__, [
            'file_id' => $file_id,
        ]);

        /** @var File $object */
        $object = $this->mapper->map($response->result, new File());

        return $object;
    }

    /**
     * Use this method to kick a user from a group or a supergroup.
     * In the case of supergroups, the user will not be able to return to the group
     * on their own using invite links, etc.,
     * unless {@see https://core.telegram.org/bots/api#unbanchatmember unbanned} first.
     * The bot must be an administrator in the group for this to work. Returns True on success.
     * Note: This will method only work if the ‘All Members Are Admins’ setting is off in the target group.
     * Otherwise members may only be removed by the group's creator or by the member that added them.
     * @see https://core.telegram.org/bots/api#banchatmember
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function banChatMember(int|string $chat_id, int $user_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup.
     * The user will not return to the group automatically, but will be able to join via link, etc.
     * The bot must be an administrator in the group for this to work.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unbanchatmember
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function unbanChatMember(int|string $chat_id, int $user_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup
     * for this to work and must have the appropriate admin rights.
     * Pass True for all boolean parameters to lift restrictions from a user. Returns True on success.
     * @see https://core.telegram.org/bots/api#restrictchatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;username)
     * @param int $user_id Unique identifier of the target user
     * @param ChatPermissions $permissions A ChatPermissions object for new user permissions
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     * @throws JsonException
     */
    public function restrictChatMember(
        int|string $chat_id,
        int $user_id,
        ChatPermissions $permissions,
        array $opt = [],
    ): bool {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'user_id' => $user_id,
            'permissions' => json_encode($permissions, JSON_THROW_ON_ERROR),
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#promotechatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;username)
     * @param int $user_id Unique identifier of the target user
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function promoteChatMember(int|string $chat_id, int $user_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param string $custom_title New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @return bool
     * @throws TelegramException
     */
    public function setChatAdministratorCustomTitle(int|string $chat_id, int $user_id, string $custom_title): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
            'custom_title' => $custom_title,
        ]);

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
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     */
    public function banChatSenderChat(int|string $chat_id, int $sender_chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'sender_chat_id' => $sender_chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unban a previously banned channel chat in a supergroup or channel.
     * The bot must be an administrator for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     */
    public function unbanChatSenderChat(int|string $chat_id, int $sender_chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'sender_chat_id' => $sender_chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and must have the can_restrict_members admin rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatpermissions
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param ChatPermissions $permissions A ChatPermissions object for new default chat permissions
     * @return bool
     * @throws TelegramException
     * @throws JsonException
     */
    public function setChatPermissions(int|string $chat_id, ChatPermissions $permissions): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
                'chat_id' => $chat_id,
                'permissions' => json_encode($permissions, JSON_THROW_ON_ERROR),
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
     *
     * > Note: Each administrator in a chat generates their own invite links.
     * > Bots can't use invite links generated by other administrators.
     * > If you want your bot to work with invite links, it will need to generate its own link
     * > using {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink} or by
     * > calling the {@see https://core.telegram.org/bots/api#getchat getChat} method.
     * > If your bot needs to generate a new primary invite link replacing its previous one,
     * > use {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink} again.
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return string
     * @throws TelegramException
     */
    public function exportChatInviteLink(int|string $chat_id): string
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ]);

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
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param array $opt Optional parameters
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function createChatInviteLink(int|string $chat_id, array $opt = []): ChatInviteLink
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
        ], $opt));

        /** @var ChatInviteLink $object */
        $object = $this->mapper->map($response->result, new ChatInviteLink());

        return $object;
    }

    /**
     * Use this method to edit a non-primary invite link created by the bot.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns the edited invite link as a
     * {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $invite_link The invite link to edit
     * @param array $opt Optional parameters
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function editChatInviteLink(int|string $chat_id, string $invite_link, array $opt = []): ChatInviteLink
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'invite_link' => $invite_link,
        ], $opt));

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
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $invite_link The invite link to edit
     * @return ChatInviteLink
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function revokeChatInviteLink(int|string $chat_id, string $invite_link): ChatInviteLink
    {
        $response = $this->endpoint(__FUNCTION__, [
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
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool
     * @throws TelegramException
     */
    public function approveChatJoinRequest(int|string $chat_id, int $user_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to decline a chat join request.
     * The bot must be an administrator in the chat for this to work and
     * must have the can_invite_users administrator right. Returns True on success.
     * @see https://core.telegram.org/bots/api#declinechatjoinrequest
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool
     * @throws TelegramException
     */
    public function declineChatJoinRequest(int|string $chat_id, int $user_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatphoto
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param mixed $photo New chat photo, uploaded using multipart/form-data
     * @return bool
     * @throws TelegramException
     */
    public function setChatPhoto(int|string $chat_id, mixed $photo): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'photo' => $photo,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatphoto
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return bool
     * @throws TelegramException
     */
    public function deleteChatPhoto(int|string $chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the title of a chat.
     * Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchattitle
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $title New chat title, 1-255 characters
     * @return bool
     * @throws TelegramException
     */
    public function setChatTitle(int|string $chat_id, string $title): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'title' => $title,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the description of a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must
     * have the appropriate admin rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatdescription
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function setChatDescription(int|string $chat_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to pin a message in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’
     * admin right in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#pinchatmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of a message to pin
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function pinChatMessage(int|string $chat_id, int $message_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
            'message_id' => $message_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to unpin a message in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’
     * admin right in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function unpinChatMessage(int|string $chat_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'chat_id' => $chat_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to clear the list of pinned messages in a chat.
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work
     * and must have the 'can_pin_messages' admin right in a supergroup or 'can_edit_messages' admin right in a channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return bool
     * @throws TelegramException
     */
    public function unpinAllChatMessages(int|string $chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#leavechat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return bool
     * @throws TelegramException
     */
    public function leaveChat(int|string $chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to get up to date information about the chat
     * (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a {@see https://core.telegram.org/bots/api#chat Chat} object on success.
     * @see https://core.telegram.org/bots/api#getchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return Chat
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChat(int|string $chat_id): Chat
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ], false);

        /** @var Chat $object */
        $object = $this->mapper->map($response->result, new Chat());

        return $object;
    }

    /**
     * Use this method to get a list of administrators in a chat.
     * On success, returns an Array of {@see https://core.telegram.org/bots/api#chatmember ChatMember}
     * objects that contains information about all chat administrators except other bots.
     * If the chat is a group or a supergroup and no administrators were appointed, only the creator will be returned.
     * @see https://core.telegram.org/bots/api#getchatadministrators
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return ChatMember[]
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChatAdministrators(int|string $chat_id): array
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ], false);

        /** @var array $resultArray */
        $resultArray = $response->result;

        /** @var ChatMember[] $object */
        $object = $this->mapper->mapArray($resultArray, [], ChatMember::class);

        return $object;
    }

    /**
     * Use this method to get the number of members in a chat.
     * Returns Int on success.
     * @see https://core.telegram.org/bots/api#getchatmembercount
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return int
     * @throws TelegramException
     */
    public function getChatMemberCount(int|string $chat_id): int
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ], false);

        /** @var int $object */
        $object = $response->result;

        return $object;
    }

    /**
     * Use this method to get information about a member of a chat.
     * Returns a {@see https://core.telegram.org/bots/api#chatmember ChatMember} object on success.
     * @see https://core.telegram.org/bots/api#getchatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return ChatMember
     * @throws TelegramException
     * @throws JsonMapper_Exception
     */
    public function getChatMember(int|string $chat_id, int $user_id): ChatMember
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ], false);

        /** @var ChatMember $object */
        $object = $this->mapper->map($response->result, new ChatMember());

        return $object;
    }

    /**
     * Use this method to set a new group sticker set for a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in
     * {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this  method.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatstickerset
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param string $sticker_set_name Name of the sticker set to be set as the group sticker set
     * @return bool
     * @throws TelegramException
     */
    public function setChatStickerSet(int|string $chat_id, string $sticker_set_name): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
            'sticker_set_name' => $sticker_set_name,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to delete a group sticker set from a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in
     * {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this method.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatstickerset
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool
     * @throws TelegramException
     */
    public function deleteChatStickerSet(int|string $chat_id): bool
    {
        $response = $this->endpoint(__FUNCTION__, [
            'chat_id' => $chat_id,
        ]);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to send answers to callback queries sent from
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating inline keyboards}.
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     * On success, True is returned.
     *
     * > Alternatively, the user can be redirected to the specified Game URL.
     * > For this option to work, you must first create a game for your bot via BotFather and accept the terms.
     * > Otherwise, you may use links like telegram.me/your_bot?start=XXXX that open your bot with a parameter.
     * @see https://core.telegram.org/bots/api#answercallbackquery
     * @param string $callback_query_id Unique identifier for the query to be answered
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     */
    public function answerCallbackQuery(string $callback_query_id, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'callback_query_id' => $callback_query_id,
        ], $opt));

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * Use this method to change the list of the bot's commands.
     * See {@see https://core.telegram.org/bots#commands https://core.telegram.org/bots#commands}
     * for more details about bot commands.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmycommands
     * @param BotCommand[] $commands A list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param array $opt Optional parameters
     * @return bool
     * @throws TelegramException
     * @throws JsonException
     */
    public function setMyCommands(array $commands, array $opt = []): bool
    {
        $response = $this->endpoint(__FUNCTION__, array_merge([
            'commands' => json_encode($commands, JSON_THROW_ON_ERROR),
        ], $opt));

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
        $response = $this->endpoint(__FUNCTION__, $opt);

        /** @var bool $object */
        $object = property_exists($response->result, 'scalar') ? $response->result->scalar : $response->result;

        return $object;
    }

    /**
     * UUse this method to get the current list of the bot's commands. Requires no parameters.
     * Returns Array of {@see https://core.telegram.org/bots/api#botcommand BotCommand} on success.
     * @see https://core.telegram.org/bots/api#getmycommands
     * @param array $opt Optional parameters
     * @return BotCommand[]
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getMyCommands(array $opt = []): array
    {
        $response = $this->endpoint(__FUNCTION__, $opt);

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
     * @param array $opt Optional parameters
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
     * @param array $opt Optional parameters
     * @return MenuButton
     * @throws JsonMapper_Exception
     * @throws TelegramException
     */
    public function getChatMenuButton(array $opt = []): MenuButton
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
     * @param array $opt Optional parameters
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
     * @param array $opt Optional parameters
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
