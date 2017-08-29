<?php

namespace TelegramBot\Parameters;

class getUserProfilePhotosParameters extends BaseParameter
{
	private $user_id;
	private $offset;
	private $limit;

	private function __construct(){}

	public static function init()
	{
		return new getUserProfilePhotosParameters();
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
	 * OPTIONAL - Sequential number of the first photo to be returned. By default, all photos are returned.
	 * @param int $value
	 * @return $this
	 */
	public function offset($value)
	{
		$this->offset=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Limits the number of photos to be retrieved. Values between 1—100 are accepted. Defaults to 100.
	 * @param int $value
	 * @return $this
	 */
	public function limit($value)
	{
		$this->limit=$value;
		return $this;
	}

}