<?php

namespace TelegramBot\Parameters;

class sendContactParameters extends BaseSendParameter
{
	private $phone_number;
	private $first_name;
	private $last_name;

	private function __construct(){}

	public static function init()
	{
		return new sendContactParameters();
	}

	/**
	 * REQUIRED - Contact's phone number
	 * @param string $value
	 * @return $this
	 */
	public function phone_number($value)
	{
		$this->phone_number=$value;
		return $this;
	}

	/**
	 * REQUIRED - Contact's first name
	 * @param string $value
	 * @return $this
	 */
	public function first_name($value)
	{
		$this->first_name=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Contact's last name
	 * @param string $value
	 * @return $this
	 */
	public function last_name($value)
	{
		$this->last_name=$value;
		return $this;
	}
}