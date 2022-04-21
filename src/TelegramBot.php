<?php

namespace TelegramBot;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Str;
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

    protected string $token;
    protected Hydrator $hydrator;
    protected ClientInterface $http;
    protected array $config;

    /** @var Update Webhook update */
    public $webhookData;

    /** @var Update[] GetUpdates data */
    public $updatesData;

    public function __construct(string $token, array $config = [])
    {
        //set bot token
        $this->token = $token;

        //set bot config
        $this->config = array_merge([
            'api_url' => self::DEFAULT_API_URL,
            'timeout' => 5,
            'is_local' => false,
        ], $config);

        //set json mapper
        $this->hydrator = new JsonMapper();

        //set http client
        $this->http = new Guzzle(array_merge([
            'base_uri' => $this->getApiUrl(),
            'timeout' => $this->config['timeout'],
        ], $this->config['client'] ?? []));

        $this->webhookData = $this->getWebhookUpdate();
    }

    public function getApiUrl(string $path = ''): string
    {
        return (string)Str::of($this->config['api_url'])
            ->finish('/')
            ->append('bot')
            ->append($this->token)
            ->finish('/')
            ->append(Str::after($path, '/'));
    }

    public function getFileUrl(string $path = ''): string
    {
        return (string)Str::of($this->config['api_url'])
            ->finish('/')
            ->append('file/bot')
            ->append($this->token)
            ->finish('/')
            ->append(Str::after($path, '/'));
    }

    //region KEYBOARDS

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
