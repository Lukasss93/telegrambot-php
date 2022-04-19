<?php

namespace TelegramBot;

use JsonMapper as JsonMapperLegacy;
use JsonMapper_Exception;
use ReflectionClass;
use TelegramBot\Hydrator\Hydrator;
use TelegramBot\Hydrator\JsonMapper;
use TelegramBot\Types\Response;
use TelegramBot\Types\Update;
use TelegramBot\Types\WebhookInfo;

/**
 * Class TelegramBot
 * For parameters of methods see: https://core.telegram.org/bots/api
 * @package TelegramBot
 */
class TelegramBot
{
    use Client;

    /** @var bool Automatic split message */
    public $splitLongMessage = false;

    /** @var Update Webhook update */
    public $webhookData;

    /** @var Update[] GetUpdates data */
    public $updatesData;

    /** @var string Bot token */
    private $token;

    /** @var JsonMapperLegacy */
    private $mapper;

    protected Hydrator $hydrator;

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
        $this->mapper = new JsonMapperLegacy();
        $this->mapper->bStrictNullTypes = false;
        $this->mapper->undefinedPropertyHandler = static function ($object, $propName, $jsonValue) {
            $object->{$propName} = $jsonValue;
        };
        $this->hydrator = new JsonMapper();

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

    //region UTILITIES

    /**
     * Download a file from Telegram Server
     * @param string $telegram_file_path
     * @param string $local_file_path
     */
    public function downloadFile(string $telegram_file_path, string $local_file_path): void
    {
        $telegramBotUrl = empty($this->botServerUrl) ? 'https://api.telegram.org' : $this->botServerUrl;
        $file_url = "$telegramBotUrl/file/bot".$this->token.'/'.$telegram_file_path;
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
        $telegramBotUrl = empty($this->botServerUrl) ? 'https://api.telegram.org' : $this->botServerUrl;
        $response = $this->sendRequest(
            "$telegramBotUrl/bot".$this->token.'/'.$api,
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
