<?php

namespace TelegramBot\Types;

/** This object contains basic information about a successful payment. */
class SuccessfulPayment {
	/** @var string Three-letter ISO 4217 currency code */
	public $currency;
	
	/** @var int Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). */
	public $total_amount;
	
	/** @var string Bot specified invoice payload */
	public $invoice_payload;
	
	/** @var string Optional. Identifier of the shipping option chosen by the user */
	public $shipping_option_id;
	
	/** @var OrderInfo Optional. Order info provided by the user */
	public $order_info;
	
	/** @var string Telegram payment identifier */
	public $telegram_payment_charge_id;
	
	/** @var string Provider payment identifier */
	public $provider_payment_charge_id;
}
