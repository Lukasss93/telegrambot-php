<?php

namespace TelegramBot;


class TelegramUpdateTypes
{
    const CALLBACK_QUERY = 'callback_query';
    const EDITED_MESSAGE = 'edited_message';
    const REPLY = 'reply';
    const FORWARD_USER = 'forward_user';
    const FORWARD_CHAT = 'forward_chat';
    const MESSAGE = 'message';
    const GAME = 'game';
    const STICKER = 'sticker';
    const PHOTO = 'photo';
    const VIDEO = 'video';
    const VIDEO_NOTE = 'video_note';
    const AUDIO = 'audio';
    const VOICE = 'voice';
    const DOCUMENT = 'document';
    const LOCATION = 'location';
    const VENUE = 'venue';
    const CONTACT = 'contact';
    const PINNED_MESSAGE = 'pinned_message';
    const INVOICE = 'invoice';
    const SUCCESSFUL_PAYMENT = 'successful_payment';
}