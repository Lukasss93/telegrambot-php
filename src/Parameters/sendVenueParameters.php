<?php

namespace TelegramBot\Parameters;

class sendVenueParameters extends BaseSendParameter
{
	private $latitude;
	private $longitude;
	private $title;
	private $address;
	private $foursquare_id;

	private function __construct(){}

	public static function init()
	{
		return new sendVenueParameters();
	}

	/**
	 * REQUIRED - Latitude of the venue
	 * @param float $value
	 * @return $this
	 */
	public function latitude($value)
	{
		$this->latitude=$value;
		return $this;
	}

	/**
	 * REQUIRED - Longitude of the venue
	 * @param float $value
	 * @return $this
	 */
	public function longitude($value)
	{
		$this->longitude=$value;
		return $this;
	}

	/**
	 * REQUIRED - Name of the venue
	 * @param string $value
	 * @return $this
	 */
	public function title($value)
	{
		$this->title=$value;
		return $this;
	}

	/**
	 * REQUIRED - Address of the venue
	 * @param string $value
	 * @return $this
	 */
	public function address($value)
	{
		$this->address=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Foursquare identifier of the venue
	 * @param string $value
	 * @return $this
	 */
	public function foursquare_id($value)
	{
		$this->foursquare_id=$value;
		return $this;
	}
}