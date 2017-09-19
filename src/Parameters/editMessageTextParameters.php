<?php

namespace TelegramBot\Parameters;

class editMessageTextParameters extends BaseEditParameter
{
	private $text;
	private $parse_mode;
	private $disable_web_page_preview;

	private function __construct(){}

	public static function init()
	{
		return new editMessageTextParameters();
	}

	/**
	 * REQUIRED - New text of the message
	 * @param string $value
	 * @return $this
	 */
	public function text($value)
	{
		$this->text=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
	 * @param string $value
	 * @return $this
	 */
	public function parse_mode($value)
	{
		$this->parse_mode=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Disables link previews for links in this message
	 * @param bool $value
	 * @return $this
	 */
	public function disable_web_page_preview($value)
	{
		$this->disable_web_page_preview=$value;
		return $this;
	}

}