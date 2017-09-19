<?php

namespace TelegramBot\Parameters;

use TelegramBot\Types\InlineQueryResultArticle;
use TelegramBot\Types\InlineQueryResultAudio;
use TelegramBot\Types\InlineQueryResultCachedAudio;
use TelegramBot\Types\InlineQueryResultCachedDocument;
use TelegramBot\Types\InlineQueryResultCachedGif;
use TelegramBot\Types\InlineQueryResultCachedMpeg4Gif;
use TelegramBot\Types\InlineQueryResultCachedPhoto;
use TelegramBot\Types\InlineQueryResultCachedSticker;
use TelegramBot\Types\InlineQueryResultCachedVideo;
use TelegramBot\Types\InlineQueryResultCachedVoice;
use TelegramBot\Types\InlineQueryResultContact;
use TelegramBot\Types\InlineQueryResultDocument;
use TelegramBot\Types\InlineQueryResultGame;
use TelegramBot\Types\InlineQueryResultGif;
use TelegramBot\Types\InlineQueryResultLocation;
use TelegramBot\Types\InlineQueryResultMpeg4Gif;
use TelegramBot\Types\InlineQueryResultPhoto;
use TelegramBot\Types\InlineQueryResultVenue;
use TelegramBot\Types\InlineQueryResultVideo;
use TelegramBot\Types\InlineQueryResultVoice;

class answerInlineQueryParameters extends BaseParameter
{
	private $inline_query_id;
	private $results;
	private $cache_time;
	private $is_personal;
	private $next_offset;
	private $switch_pm_text;
	private $switch_pm_parameter;

	private function __construct(){}

	public static function init()
	{
		return new answerInlineQueryParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the answered query
	 * @param string $value
	 * @return $this
	 */
	public function inline_query_id($value)
	{
		$this->inline_query_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - An array of results for the inline query
	 * @param InlineQueryResultCachedAudio[]|InlineQueryResultCachedDocument[]|InlineQueryResultCachedGif[]|InlineQueryResultCachedMpeg4Gif[]|InlineQueryResultCachedPhoto[]|InlineQueryResultCachedSticker[]|InlineQueryResultCachedVideo[]|InlineQueryResultCachedVoice[]|InlineQueryResultArticle[]|InlineQueryResultAudio[]|InlineQueryResultContact[]|InlineQueryResultGame[]|InlineQueryResultDocument[]|InlineQueryResultGif[]|InlineQueryResultLocation[]|InlineQueryResultMpeg4Gif[]|InlineQueryResultPhoto[]|InlineQueryResultVenue[]|InlineQueryResultVideo[]|InlineQueryResultVoice[] $value
	 * @return $this
	 */
	public function results($value)
	{
		$this->results=json_encode($value);
		return $this;
	}

	/**
	 * OPTIONAL - The maximum amount of time in seconds that the result of the inline query may be cached on the server.
	 * Defaults to 300.
	 * @param int $value
	 * @return $this
	 */
	public function cache_time($value)
	{
		$this->cache_time=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query
	 * @param bool $value
	 * @return $this
	 */
	public function is_personal($value)
	{
		$this->is_personal=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass the offset that a client should send in the next query with the same text to receive more results.
	 * Pass an empty string if there are no more results or if you don‘t support pagination. Offset length can’t exceed 64 bytes.
	 * @param string $value
	 * @return $this
	 */
	public function next_offset($value)
	{
		$this->next_offset=$value;
		return $this;
	}

	/**
	 * OPTIONAL - If passed, clients will display a button with specified text that switches the user to a
	 * private chat with the bot and sends the bot a start message with the parameter switch_pm_parameter
	 * @param string $value
	 * @return $this
	 */
	public function switch_pm_text($value)
	{
		$this->switch_pm_text=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Deep-linking parameter for the /start message sent to the bot when user presses the switch button. 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.
	 * Example: An inline bot that sends YouTube videos can ask the user to connect the bot to their YouTube
	 * account to adapt search results accordingly.
	 * To do this, it displays a ‘Connect your YouTube account’ button above the results, or even before showing any.
	 * The user presses the button, switches to a private chat with the bot and, in doing so, passes a start parameter
	 * that instructs the bot to return an oauth link. Once done, the bot can offer a switch_inline button so that the
	 * user can easily return to the chat where they wanted to use the bot's inline capabilities.
	 * @param string $value
	 * @return $this
	 */
	public function switch_pm_parameter($value)
	{
		$this->switch_pm_parameter=$value;
		return $this;
	}
}