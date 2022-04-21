<?php

namespace TelegramBot;

use GuzzleHttp\Client as Guzzle;
use JsonMapper_Exception;
use Psr\Http\Client\ClientInterface;
use TelegramBot\Hydrator\Hydrator;
use TelegramBot\Hydrator\JsonMapper;
use TelegramBot\Types\Update;

/**
 * Class TelegramBot
 * For parameters of methods see: https://core.telegram.org/bots/api
 * @package TelegramBot
 */
class TelegramBot
{
    use Client;

    protected const DEFAULT_API_URL = 'https://api.telegram.org';

    /** @var Update Webhook update */
    public $webhookData;

    /** @var Update[] GetUpdates data */
    public $updatesData;

    protected string $token;
    protected Hydrator $hydrator;
    protected ClientInterface $http;

    /** @var string Bot API server url */
    private $botServerUrl;

    /**
     * TelegramBot constructor
     * @param string $token Bot token
     * @param string|null $botServerUrl Bot API server url
     * @throws JsonMapper_Exception
     */
    public function __construct(string $token, ?string $botServerUrl = null)
    {
        $baseUri = $botServerUrl ?? self::DEFAULT_API_URL;

        $this->hydrator = new JsonMapper();
        $this->http = new Guzzle([
            'base_uri' => "$baseUri/bot$token/",
            'timeout' => 5,
        ]);

        //telegram data
        $this->token = $token;
        $this->botServerUrl = $baseUri;
        $this->webhookData = $this->getWebhookUpdate();
    }

    //TODO: config
    //region KEYBOARDS

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


    //endregion
}
