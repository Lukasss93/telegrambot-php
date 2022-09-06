<?php

namespace TelegramBot\Types;

/**
 * This object represents one button of the reply keyboard.
 * For simple text buttons String can be used instead of this object to specify text of the button.
 * Optional fields are mutually exclusive.
 *
 * Note: request_contact and request_location options will only work in Telegram versions released after 9 April, 2016.
 * Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton
{
    /**
     * Text of the button.
     * If none of the optional fields are used, it will be sent to the bot as a message when the button is pressed
     */
    public string $text;

    /**
     * Optional. If True, the user's phone number will be sent as a contact when the button is pressed.
     * Available in private chats only
     */
    public ?bool $request_contact = null;

    /**
     * Optional. If True, the user's current location will be sent when the button is pressed.
     * Available in private chats only
     */
    public ?bool $request_location = null;

    /**
     * Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is
     * pressed. Available in private chats only
     */
    public ?KeyboardButtonPollType $request_poll = null;

    /**
     * Optional. If specified, the described {@see https://core.telegram.org/bots/webapps Web App}
     * will be launched when the button is pressed.
     * The Web App will be able to send a “web_app_data” service message.
     * Available in private chats only.
     */
    public ?WebAppInfo $web_app;
}
