<?php

namespace TelegramBot\Types;

/** Contains information about the current status of a webhook. */
class WebhookInfo {
	/** @var string Webhook URL, may be empty if webhook is not set up */
	public $url;
	
	/** @var bool True, if a custom certificate was provided for webhook certificate checks */
	public $has_custom_certificate;
	
	/** @var int Number of updates awaiting delivery */
	public $pending_update_count;
	
	/** @var int Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook */
	public $last_error_date;
	
	/** @var string Optional. Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook */
	public $last_error_message;
	
	/** @var int Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery */
	public $max_connections;
	
	/** @var string[] Optional. A list of update types the bot is subscribed to. Defaults to all update types */
	public $allowed_updates;
}
