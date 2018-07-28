<?php

namespace TelegramBot\Types;

use TelegramBot\Constants\MessageTypes;

/** This object represents a message. */
class Message {
	/** @var int Unique message identifier inside this chat */
	public $message_id;
	
	/** @var User Optional. Sender, can be empty for messages sent to channels */
	public $from;
	
	/** @var int Date the message was sent in Unix time */
	public $date;
	
	/** @var Chat Conversation the message belongs to */
	public $chat;
	
	/** @var User Optional. For forwarded messages, sender of the original message */
	public $forward_from;
	
	/** @var Chat Optional. For messages forwarded from a channel, information about the original channel */
	public $forward_from_chat;
	
	/** @var int Optional. For forwarded channel posts, identifier of the original message in the channel */
	public $forward_from_message_id;
	
	/** @var string Optional. Signature of the post author for messages forwarded from channels */
	public $forward_signature;
	
	/** @var int Optional. For forwarded messages, date the original message was sent in Unix time */
	public $forward_date;
	
	/** @var Message Optional. For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply */
	public $reply_to_message;
	
	/** @var int Optional. Date the message was last edited in Unix time */
	public $edit_date;
	
	/** @var string Optional. Signature of the post author for messages in channels */
	public $author_signature;
	
	/** @var string Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters */
	public $text;
	
	/** @var MessageEntity[] Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text */
	public $entities;
	
	/** @var MessageEntity[] Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption */
	public $caption_entities;
	
	/** @var Audio Optional. Message is an audio file, information about the file */
	public $audio;
	
	/** @var Document Optional. Message is a general file, information about the file */
	public $document;
	
	/** @var Animation $animation Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set */
	public $animation;
	
	/** @var Game Optional. Message is a game, information about the game */
	public $game;
	
	/** @var PhotoSize[] Optional. Message is a photo, available sizes of the photo */
	public $photo;
	
	/** @var Sticker Optional. Message is a sticker, information about the sticker */
	public $sticker;
	
	/** @var Video Optional. Message is a video, information about the video */
	public $video;
	
	/** @var Voice Optional. Message is a voice message, information about the file */
	public $voice;
	
	/** @var VideoNote Optional. Message is a video note, information about the video message */
	public $video_note;
	
	/** @var User[] Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members) */
	public $new_chat_members;
	
	/** @var string Optional. Caption for the document, photo or video, 0-200 characters */
	public $caption;
	
	/** @var Contact Optional. Message is a shared contact, information about the contact */
	public $contact;
	
	/** @var Location Optional. Message is a shared location, information about the location */
	public $location;
	
	/** @var Venue Optional. Message is a venue, information about the venue */
	public $venue;
	
	/** @var User Optional. A new member was added to the group, information about them (this member may be the bot itself) */
	public $new_chat_member;
	
	/** @var User Optional. A member was removed from the group, information about them (this member may be the bot itself) */
	public $left_chat_member;
	
	/** @var string Optional. A chat title was changed to this value */
	public $new_chat_title;
	
	/** @var PhotoSize[] Optional. A chat photo was change to this value */
	public $new_chat_photo;
	
	/** @var bool Optional. Service message: the chat photo was deleted */
	public $delete_chat_photo;
	
	/** @var bool Optional. Service message: the group has been created */
	public $group_chat_created;
	
	/** @var bool Optional. Service message: the supergroup has been created. This field can‘t be received in a message coming through updates, because bot can’t be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup */
	public $supergroup_chat_created;
	
	/** @var bool Optional. Service message: the channel has been created. This field can‘t be received in a message coming through updates, because bot can’t be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel */
	public $channel_chat_created;
	
	/** @var int Optional. The group has been migrated to a supergroup with the specified identifier. This number may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier */
	public $migrate_to_chat_id;
	
	/** @var int Optional. The supergroup has been migrated from a group with the specified identifier. This number may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier */
	public $migrate_from_chat_id;
	
	/** @var Message Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply */
	public $pinned_message;
	
	/** @var Invoice Optional. Message is an invoice for a payment, information about the invoice. */
	public $invoice;
	
	/** @var SuccessfulPayment Optional. Message is a service message about a successful payment, information about the payment. */
	public $successful_payment;
	
	/** @var String Optional. The domain name of the website on which the user has logged in. https://core.telegram.org/widgets/login */
	public $connected_website;
	
	/** @var PassportData $passport_data Optional. Telegram Passport data */
	public $passport_data;
	
	/**
	 * Check if the message is a command
	 * @return bool
	 */
	public function isCommand() {
		return $this->getCommand() !== null;
	}
	
	/**
	 * Returns only the command string without @BotUsername
	 * Example:
	 * IN: /hello or /hello@MyDearBot
	 * OUT: /hello
	 * @return string
	 */
	public function getCommand() {
		if($this->text !== null) {
			$result = preg_match('/^(\/\w+)(@\w+)?(.+)?$/', $this->text, $matches);
			
			if(!$result) {
				return null;
			}
			else {
				return $matches[1];
			}
		}
		return null;
	}
	
	/**
	 * Returns the args as array or as string
	 * @param bool $asString
	 * @return array|string
	 */
	public function getArgs($asString = false) {
		if($this->text !== null) {
			$commandArray = explode(' ', $this->text);
			array_shift($commandArray);
			
			if($asString) {
				return implode(' ', $commandArray);
			}
			else {
				return $commandArray;
			}
		}
		return null;
	}
	
	/**
	 * Check if the message is forwarded
	 * @return bool
	 */
	public function isForwarded() {
		return !is_null($this->forward_from) || !is_null($this->forward_from_chat);
	}
	
	/**
	 * Return the current message type
	 * @return false|string
	 */
	public function getType() {
		if($this->text !== null) {
			return MessageTypes::TEXT;
		}
		else if($this->audio !== null) {
			return MessageTypes::AUDIO;
		}
		else if($this->document !== null) {
			return MessageTypes::DOCUMENT;
		}
		else if($this->animation !== null) {
			return MessageTypes::ANIMATION;
		}
		else if($this->game !== null) {
			return MessageTypes::GAME;
		}
		else if($this->photo !== null) {
			return MessageTypes::PHOTO;
		}
		else if($this->sticker !== null) {
			return MessageTypes::STICKER;
		}
		else if($this->video !== null) {
			return MessageTypes::VIDEO;
		}
		else if($this->voice !== null) {
			return MessageTypes::VOICE;
		}
		else if($this->video_note !== null) {
			return MessageTypes::VIDEO_NOTE;
		}
		else if($this->new_chat_members !== null) {
			return MessageTypes::NEW_CHAT_MEMBERS;
		}
		else if($this->contact !== null) {
			return MessageTypes::CONTACT;
		}
		else if($this->location !== null) {
			return MessageTypes::LOCATION;
		}
		else if($this->venue !== null) {
			return MessageTypes::VENUE;
		}
		else if($this->new_chat_member !== null) {
			return MessageTypes::NEW_CHAT_MEMBER;
		}
		else if($this->left_chat_member !== null) {
			return MessageTypes::LEFT_CHAT_MEMBER;
		}
		else if($this->new_chat_title !== null) {
			return MessageTypes::NEW_CHAT_TITLE;
		}
		else if($this->new_chat_photo !== null) {
			return MessageTypes::NEW_CHAT_PHOTO;
		}
		else if($this->delete_chat_photo !== null) {
			return MessageTypes::DELETE_CHAT_PHOTO;
		}
		else if($this->group_chat_created !== null) {
			return MessageTypes::GROUP_CHAT_CREATED;
		}
		else if($this->supergroup_chat_created !== null) {
			return MessageTypes::SUPERGROUP_CHAT_CREATED;
		}
		else if($this->channel_chat_created !== null) {
			return MessageTypes::CHANNEL_CHAT_CREATED;
		}
		else if($this->migrate_to_chat_id !== null) {
			return MessageTypes::MIGRATE_TO_CHAT_ID;
		}
		else if($this->migrate_from_chat_id !== null) {
			return MessageTypes::MIGRATE_FROM_CHAT_ID;
		}
		else if($this->pinned_message !== null) {
			return MessageTypes::PINNED_MESSAGE;
		}
		else if($this->invoice !== null) {
			return MessageTypes::INVOICE;
		}
		else if($this->successful_payment !== null) {
			return MessageTypes::SUCCESSFUL_PAYMENT;
		}
		
		return false;
	}
	
}
