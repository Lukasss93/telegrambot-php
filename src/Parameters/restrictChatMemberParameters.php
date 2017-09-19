<?php

namespace TelegramBot\Parameters;

class restrictChatMemberParameters extends BaseParameter
{
	private $chat_id;
	private $user_id;
	private $until_date;
	private $can_send_messages;
	private $can_send_media_messages;
	private $can_send_other_messages;
	private $can_add_web_page_previews;

	private function __construct(){}

	public static function init()
	{
		return new restrictChatMemberParameters();
	}

	/**
	 * REQUIRED - Unique identifier for the target group or username of the target supergroup or channel (in the format [at]channelusername)
	 * @param int|string $value
	 * @return $this
	 */
	public function chat_id($value)
	{
		$this->chat_id=$value;
		return $this;
	}

	/**
	 * REQUIRED - Unique identifier of the target user
	 * @param int $value
	 * @return $this
	 */
	public function user_id($value)
	{
		$this->user_id=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Date when restrictions will be lifted for the user, unix time.
	 * If user is restricted for more than 366 days or less than 30 seconds from the current time, they are considered to be restricted forever
	 * @param int $value
	 * @return $this
	 */
	public function until_date($value)
	{
		$this->until_date=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the user can send text messages, contacts, locations and venues
	 * @param bool $value
	 * @return $this
	 */
	public function can_send_messages($value)
	{
		$this->can_send_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the user can send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages
	 * @param bool $value
	 * @return $this
	 */
	public function can_send_media_messages($value)
	{
		$this->can_send_media_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages
	 * @param bool $value
	 * @return $this
	 */
	public function can_send_other_messages($value)
	{
		$this->can_send_other_messages=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Pass True, if the user may add web page previews to their messages, implies can_send_media_messages
	 * @param bool $value
	 * @return $this
	 */
	public function can_add_web_page_previews($value)
	{
		$this->can_add_web_page_previews=$value;
		return $this;
	}

}