<?php

namespace TelegramBot\Parameters;

class setWebhookParameters extends BaseParameter
{
	private $url;
	private $certificate;
	private $max_connections;
	private $allowed_updates;

	private function __construct(){}

	public static function init()
	{
		return new setWebhookParameters();
	}

	/**
	 * REQUIRED - HTTPS url to send updates to. Use an empty string to remove webhook integration
	 * @param string $value
	 * @return $this
	 */
	public function url($value)
	{
		$this->url=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
	 * @param string $value File path
	 * @return $this
	 */
	public function certificate($value)
	{
		$this->certificate=$value;
		return $this;
	}

	/**
	 * OPTIONAL - Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100.
	 * Defaults to 40. Use lower values to limit the load on your bot‘s server, and higher values to increase your bot’s throughput.
	 * @param int $value
	 * @return $this
	 */
	public function max_connections($value)
	{
		$this->max_connections=$value;
		return $this;
	}

	/**
	 * OPTIONAL - List the types of updates you want your bot to receive.
	 * For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types.
	 * See Update for a complete list of available update types. Specify an empty list to receive
	 * all updates regardless of type (default). If not specified, the previous setting will be used.
	 * Please note that this parameter doesn't affect updates created before the call to the setWebhook,
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