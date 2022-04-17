<?php

namespace TelegramBot\Types;

/**
 * Contains information about a {@see https://core.telegram.org/bots/webapps Web App}.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo
{
    /**
     * An HTTPS URL of a Web App to be opened with additional data
     * as specified in {@see https://core.telegram.org/bots/webapps#initializing-web-apps Initializing Web Apps}
     */
    public string $url;
}
