<?php

namespace TelegramBot\Types;

/** This object represents a shipping address. */
class ShippingAddress {
	/** @var string ISO 3166-1 alpha-2 country code */
	public $country_code;
	
	/** @var string State, if applicable */
	public $state;
	
	/** @var string City */
	public $city;
	
	/** @var string First line for the address */
	public $street_line1;
	
	/** @var string Second line for the address */
	public $street_line2;
	
	/** @var string Address post code */
	public $post_code;
}
