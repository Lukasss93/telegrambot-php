<?php

namespace TelegramBot\Types;

/** This object contains information about an incoming shipping query. */
class ShippingQuery
{
	/** @var string Unique query identifier */
    public $id;
    
    /** @var User  	User who sent the query */
	public $from;
	
	/** @var string Bot specified invoice payload */
	public $invoice_payload;
	
	/** @var ShippingAddress User specified shipping address */
	public $shipping_address;
}