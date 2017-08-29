<?php

namespace TelegramBot\Parameters;

class sendLocationParameters extends BaseSendParameter
{
	private $latitude;
	private $longitude;

	private function __construct(){}

	public static function init()
	{
		return new sendLocationParameters();
	}

	/**
	 * REQUIRED - Latitude of location
	 * @param float $value
	 * @return $this
	 */
	public function latitude($value)
	{
		$this->latitude=$value;
		return $this;
	}

	/**
	 * REQUIRED - Longitude of location
	 * @param float $value
	 * @return $this
	 */
	public function longitude($value)
	{
		$this->longitude=$value;
		return $this;
	}
}