<?php

namespace TelegramBot\Parameters;

class getUpdatesParameters extends BaseParameter
{
	private $offset;
	private $limit;
	private $timeout;
	private $allowed_updates;

	private function __construct(){}

	public static function init()
	{
		return new getUpdatesParameters();
	}

	/**
	 * OPTIONAL - Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers
	 * of previously received updates. By default, updates starting with the earliest unconfirmed update are returned.
	 * An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id.
	 * The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue.
	 * All previous updates will forgotten.
	 * @param int $value
	 * @return $this
	 */
	public function offset($value)
	{
		$this->offset=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults to 100.
	 * @param int $value
	 * @return $this
	 */
	public function limit($value)
	{
		$this->limit=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling.
	 * Should be positive, short polling should be used for testing purposes only.
	 * @param int $value
	 * @return $this
	 */
	public function timeout($value)
	{
		$this->timeout=$value;
		return $this;
	}

	/**
	 * OPTIONAL - List the types of updates you want your bot to receive.
	 * For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types.
	 * See Update for a complete list of available update types. Specify an empty list to receive
	 * all updates regardless of type (default). If not specified, the previous setting will be used.
	 * Please note that this parameter doesn't affect updates created before the call to the getUpdates,
	 * so unwanted updates may be received for a short period of time.
	 * @param string[] $value
	 * @return $this
	 */
	public function allowed_updates($value)
	{
		$this->allowed_updates=$value;
		return $this;
	}

}