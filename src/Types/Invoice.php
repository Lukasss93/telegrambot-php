<?php

namespace TelegramBot\Types;

/** This object contains basic information about an invoice. */
class Invoice {
	/** @var string Product name */
	public $title;
	
	/** @var string Product description */
	public $description;
	
	/** @var string Unique bot deep-linking parameter that can be used to generate this invoice */
	public $start_parameter;
	
	/** @var string Three-letter ISO 4217 currency code */
	public $currency;
	
	/** @var int Total price in the smallest units of the currency
	 * (integer, not float/double).
	 * For example, for a price of US$ 1.45 pass amount = 145.
	 * See the exp parameter in currencies.json
	 * (https://core.telegram.org/bots/payments/currencies.json),
	 * it shows the number of digits past the decimal point
	 * for each currency (2 for the majority of currencies). */
	public $total_amount;
}
