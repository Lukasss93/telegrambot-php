<?php

namespace TelegramBot\Endpoints;

use TelegramBot\TelegramBot;
use TelegramBot\Types\Update;
use TelegramBot\Types\WebhookInfo;

/**
 * @mixin TelegramBot
 */
trait GettingUpdates
{
    /**
     * Use this method to receive incoming updates using long polling
     * ({@see https://en.wikipedia.org/wiki/Push_technology#Long_polling wiki}).
     * An Array of {@see https://core.telegram.org/bots/api#update Update} objects is returned.
     * @see https://core.telegram.org/bots/api#getupdates
     * @param array $opt Optional parameters
     * @return array
     */
    public function getUpdates(array $opt = []): array
    {
        return $this->requestJson(__FUNCTION__, $opt, Update::class, [
            'timeout' => ($opt['timeout'] ?? 0) + 1,
        ]);
    }

    /**
     * Use this method to specify a url and receive incoming updates via an outgoing webhook.
     * Whenever there is an update for the bot, we will send an HTTPS POST request to the specified url,
     * containing a JSON-serialized {@see https://core.telegram.org/bots/api#update Update}.
     * In case of an unsuccessful request, we will give up after a reasonable amount of attempts.
     * Returns True on success.
     *
     * If you'd like to make sure that the Webhook request comes from Telegram,
     * we recommend using a secret path in the URL, e.g. https://www.example.com/<token>.
     * Since nobody else knows your bot's token, you can be pretty sure it's us.
     * @see https://core.telegram.org/bots/api#setwebhook
     * @param string $url HTTPS url to send updates to. Use an empty string to remove webhook integration
     * @param array $opt Optional parameters
     * @return bool
     */
    public function setWebhook(string $url, array $opt = []): bool
    {
        $required = compact('url');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to remove webhook integration if
     * you decide to switch back to {@see https://core.telegram.org/bots/api#getupdates getUpdates}.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletewebhook
     * @param array $opt Optional parameters
     * @return bool
     */
    public function deleteWebhook(array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, $opt);
    }

    /**
     * Use this method to get current webhook status. Requires no parameters.
     * On success, returns a {@see https://core.telegram.org/bots/api#webhookinfo WebhookInfo} object.
     * If the bot is using {@see https://core.telegram.org/bots/api#getupdates getUpdates},
     * will return an object with the url field empty.
     * @see https://core.telegram.org/bots/api#getwebhookinfo
     * @return WebhookInfo
     */
    public function getWebhookInfo(): WebhookInfo
    {
        return $this->requestJson(__FUNCTION__, mapTo: WebhookInfo::class);
    }
}
