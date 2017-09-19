<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\ShippingOption;

class answerShippingQueryParameters extends BaseParameter
{
	private $shipping_query_id;
	private $ok;
	private $shipping_options;
	private $error_message;

	private function __construct(){}

	public static function init()
	{
		return new answerShippingQueryParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the query to be answered
	 * @param string $value
	 * @return $this
	 */
	public function shipping_query_id($value)
	{
		$this->shipping_query_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Specify True if delivery to the specified address is possible and False if there are any problems (for example, if delivery to the specified address is not possible)
	 * @param bool $value
	 * @return $this
	 */
	public function ok($value)
	{
		$this->ok=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if ok is True. A JSON-serialized array of available shipping options.
	 * @param ShippingOption[] $value
	 * @return $this
	 */
	public function shipping_options($value)
	{
		$this->shipping_options=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Required if ok is False. Error message in human readable form that explains why it is impossible
	 * to complete the order (e.g. "Sorry, delivery to your desired address is unavailable').
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