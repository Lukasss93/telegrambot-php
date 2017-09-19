<?php

namespace TelegramBot\Parameters;

class answerPreCheckoutQueryParameters extends BaseParameter
{
	private $pre_checkout_query_id;
	private $ok;
	private $error_message;

	private function __construct(){}

	public static function init()
	{
		return new answerPreCheckoutQueryParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the query to be answered
	 * @param string $value
	 * @return $this
	 */
	public function pre_checkout_query_id($value)
	{
		$this->pre_checkout_query_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Specify True if everything is alright (goods are available, etc.) and the bot is ready to proceed with the order.
	 * Use False if there are any problems.
	 * @param bool $value
	 * @return $this
	 */
	public function ok($value)
	{
		$this->ok=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if ok is False. Error message in human readable form that explains the reason for
	 * failure to proceed with the checkout (e.g. "Sorry, somebody just bought the last of our amazing black
	 * T-shirts while you were busy filling out your payment details. Please choose a different color or garment!").
	 * Telegram will display this message to the user.
	 * @param string $value
	 * @return $this
	 */
	public function error_message($value)
	{
		$this->error_message=$value;
		return $this;
	}
}