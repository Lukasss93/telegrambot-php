<?php

namespace TelegramBot\Constants;

class UpdateTypes
{
	const MESSAGE              = 'message';
	const EDITED_MESSAGE       = 'edited_message';
	const CHANNEL_POST         = 'channel_post';
	const EDITED_CHANNEL_POST  = 'edited_channel_post';
	const INLINE_QUERY         = 'inline_query';
	const CHOSEN_INLINE_RESULT = 'chosen_inline_result';
	const CALLBACK_QUERY       = 'callback_query';
	const SHIPPING_QUERY       = 'shipping_query';
	const PRE_CHECKOUT_QUERY   = 'pre_checkout_query';
}