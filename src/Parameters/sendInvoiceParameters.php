<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\LabeledPrice;

class sendInvoiceParameters extends BaseSendParameter
{
	private $title;
	private $description;
	private $payload;
	private $provider_token;
	private $start_parameter;
	private $currency;
	private $prices;
	private $photo_url;
	private $photo_size;
	private $photo_width;
	private $photo_height;
	private $need_name;
	private $need_phone_number;
	private $need_email;
	private $need_shipping_address;
	private $is_flexible;

	private function __construct(){}

	public static function init()
	{
		return new sendInvoiceParameters();
	}

	/**
	 * REQUIRED - Product name, 1-32 characters
	 * @param string $value
	 * @return $this
	 */
	public function title($value)
	{
		$this->title=$value;
		return $this;
	}

	/**
	 * REQUIRED - Product description, 1-255 characters
	 * @param string $value
	 * @return $this
	 */
	public function description($value)
	{
		$this->description=$value;
		return $this;
	}

	/**
	 * REQUIRED - Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
	 * @param string $value
	 * @return $this
	 */
	public function payload($value)
	{
		$this->payload=$value;
		return $this;
	}

	/**
	 * REQUIRED - Payments provider token, obtained via Botfather
	 * @param string $value
	 * @return $this
	 */
	public function provider_token($value)
	{
		$this->provider_token=$value;
		return $this;
	}

	/**
	 * REQUIRED - Unique deep-linking parameter that can be used to generate this invoice when used as a start parameter
	 * @param string $value
	 * @return $this
	 */
	public function start_parameter($value)
	{
		$this->start_parameter=$value;
		return $this;
	}

	/**
	 * REQUIRED - Three-letter ISO 4217 currency code, see more on currencies (https://core.telegram.org/bots/payments#supported-currencies)
	 * @param string $value
	 * @return $this
	 */
	public function currency($value)
	{
		$this->currency=$value;
		return $this;
	}

	/**
	 * REQUIRED - Price breakdown, a list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
	 * @param LabeledPrice[] $value
	 * @return $this
	 */
	public function prices($value)
	{
		$this->prices=$value;
		return $this;
	}

	/**
	 * OPTIONAL - URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
	 * @param string $value
	 * @return $this
	 */
	public function photo_url($value)
	{
		$this->photo_url=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Photo size
	 * @param int $value
	 * @return $this
	 */
	public function photo_size($value)
	{
		$this->photo_size=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Photo width
	 * @param int $value
	 * @return $this
	 */
	public function photo_width($value)
	{
		$this->photo_width=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Photo height
	 * @param int $value
	 * @return $this
	 */
	public function photo_height($value)
	{
		$this->photo_height=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if you require the user's full name to complete the order
	 * @param bool $value
	 * @return $this
	 */
	public function need_name($value)
	{
		$this->need_name=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if you require the user's phone number to complete the order
	 * @param bool $value
	 * @return $this
	 */
	public function need_phone_number($value)
	{
		$this->need_phone_number=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if you require the user's email to complete the order
	 * @param bool $value
	 * @return $this
	 */
	public function need_email($value)
	{
		$this->need_email=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if you require the user's shipping address to complete the order
	 * @param bool $value
	 * @return $this
	 */
	public function need_shipping_address($value)
	{
		$this->need_shipping_address=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the final price depends on the shipping method
	 * @param bool $value
	 * @return $this
	 */
	public function is_flexible($value)
	{
		$this->is_flexible=$value;
		return $this;
	}

}