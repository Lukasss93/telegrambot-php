<?php

namespace TelegramBot\Types;

/** This object represents information about an order. */
class OrderInfo
{
	/** @var string Optional. User name */
    public $name;
	
	/** @var string Optional. User's phone number */
	public $phone_number;
	
	/** @var string Optional. User email */
	public $email;
	
	/** @var ShippingAddress Optional. User shipping address */
	public $shipping_address;
}