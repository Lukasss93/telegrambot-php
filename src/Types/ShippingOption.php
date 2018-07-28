<?php

namespace TelegramBot\Types;

/** This object represents one shipping option. */
class ShippingOption {
	/** @var string Shipping option identifier */
	public $id;
	
	/** @var string Option title */
	public $title;
	
	/** @var LabeledPrice[] List of price portions */
	public $prices;
}
