<?php

namespace TelegramBot\Types;

use TelegramBot\Constants\UpdateTypes;

/**
 * This object represents an incoming update. At most one of the optional parameters can be present in any given update.
 * @package TelegramBot\Types
 */
class Update {
	/**
	 * @var int $update_id The update‘s unique identifier.
	 * Update identifiers start from a certain positive number and increase sequentially.
	 * This ID becomes especially handy if you’re using Webhooks, since it allows you to ignore
	 * repeated updates or to restore the correct update sequence, should they get out of order.
	 */
	public $update_id;
	
	/**
	 * @var Message $message Optional. New incoming message of any kind — text, photo, sticker, etc.
	 */
	public $message;
	
	/**
	 * @var Message $edited_message Optional. New version of a message that is known to the bot and was edited
	 */
	public $edited_message;
	
	/**
	 * @var Message $channel_post Optional. New incoming channel post of any kind — text, photo, sticker, etc.
	 */
	public $channel_post;
	
	/**
	 * @var Message $edited_channel_post Optional. New version of a channel post that is known to the bot and was edited
	 */
	public $edited_channel_post;
	
	/**
	 * @var InlineQuery $inline_query Optional. New incoming inline query
	 */
	public $inline_query;
	
	/**
	 * @var ChosenInlineResult $chosen_inline_result Optional. The result of an inline query that was chosen by a user
	 *     and sent to their chat partner. Please see our documentation on the feedback collecting for details on how
	 *     to enable these updates for your bot. partner.
	 */
	public $chosen_inline_result;
	
	/**
	 * @var CallbackQuery $callback_query Optional. New incoming callback query
	 */
	public $callback_query;
	
	/**
	 * @var ShippingQuery $shipping_query Optional. New incoming shipping query. Only for invoices with flexible price
	 */
	public $shipping_query;
	
	/**
	 * @var PreCheckoutQuery $pre_checkout_query Optional. New incoming pre-checkout query.
	 * Contains full information about checkout
	 */
	public $pre_checkout_query;
	
	/** @var Poll Optional. New poll state. Bots receive only updates about polls, which are sent or stopped by the bot */
	public $poll;
	
	/**
	 * Return the current update type
	 * You can use the UpdateTypes enum class
	 * @return bool|string
	 */
	public function getType() {
		if($this->message !== null) {
			return UpdateTypes::MESSAGE;
		}
		else if($this->edited_message !== null) {
			return UpdateTypes::EDITED_MESSAGE;
		}
		else if($this->channel_post !== null) {
			return UpdateTypes::CHANNEL_POST;
		}
		else if($this->edited_channel_post !== null) {
			return UpdateTypes::EDITED_CHANNEL_POST;
		}
		else if($this->inline_query !== null) {
			return UpdateTypes::INLINE_QUERY;
		}
		else if($this->chosen_inline_result !== null) {
			return UpdateTypes::CHOSEN_INLINE_RESULT;
		}
		else if($this->callback_query !== null) {
			return UpdateTypes::CALLBACK_QUERY;
		}
		else if($this->shipping_query !== null) {
			return UpdateTypes::SHIPPING_QUERY;
		}
		else if($this->pre_checkout_query !== null) {
			return UpdateTypes::PRE_CHECKOUT_QUERY;
		}
		
		return false;
	}
}
