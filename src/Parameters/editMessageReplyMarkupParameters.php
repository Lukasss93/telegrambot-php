<?php

namespace TelegramBot\Parameters;

class editMessageReplyMarkupParameters extends BaseEditParameter
{
	private function __construct(){}

	public static function init()
	{
		return new editMessageReplyMarkupParameters();
	}
}