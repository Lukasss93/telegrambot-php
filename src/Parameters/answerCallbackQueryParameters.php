<?php

namespace TelegramBot\Parameters;

class answerCallbackQueryParameters extends BaseParameter
{
	private $callback_query_id;
	private $text;
	private $show_alert;
	private $url;
	private $cache_time;

	private function __construct(){}

	public static function init()
	{
		return new answerCallbackQueryParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the query to be answered
	 * @param string $value
	 * @return $this
	 */
	public function callback_query_id($value)
	{
		$this->callback_query_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
	 * @param string $value
	 * @return $this
	 */
	public function text($value)
	{
		$this->text=$value;
		return $this;
	}

	/**
	 * OPTIONAL - If true, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
	 * @param bool $value
	 * @return $this
	 */
	public function show_alert($value)
	{
		$this->show_alert=$value;
		return $this;
	}

	/**
	 * OPTIONAL - URL that will be opened by the user's client.
	 * If you have created a Game and accepted the conditions via @Botfather,
	 * specify the URL that opens your game – note that this will only work if the query comes from a callback_game button.
	 * Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
	 * @param string $value
	 * @return $this
	 */
	public function url($value)
	{
		$this->url=$value;
		return $this;
	}

	/**
	 * OPTIONAL - The maximum amount of time in seconds that the result of the callback query may be cached client-side.
	 * Telegram apps will support caching starting in version 3.14. Defaults to 0.
	 * @param int $value
	 * @return $this
	 */
	public function cache_time($value)
	{
		$this->cache_time=$value;
		return $this;
	}
}