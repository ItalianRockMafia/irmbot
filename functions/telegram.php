<?php

function sendMessage($message){
	$chatID  					=	$message['chatID'];
	$text 	 					=	urlencode($message['text']);
	$parse_mode  				=	$message['parse_mode'];
	$disable_web_page_preview 	=	$message['disable_web_page_preview'];
	$disable_notification 	 	=	$message['disable_notification'];
	$reply_to_message_id  		=	$message['reply_to_message_id'];
	$reply_markup 	 			=	$message['reply_markup'];

	$call = TG_API_ROOT . "/sendMessage?chat_id=" . $chatID . "&text=" . $text;
	if(isset($parse_mode)){
		$call .= "&parse_mode=" . $parse_mode;
	}
	if(isset($disable_web_page_preview)){
		$call .= "&disable_web_page_preview=" . $disable_web_page_preview;
	}
	if(isset($disable_notification)){
		$call .= "&disable_notification=" . $disable_notification;
	}
	if(isset($reply_to_message_id)){
		$call .= "&reply_to_message_id" . $reply_to_message_id;
	}
	if(isset($reply_markup)){
		$call .= "&reply_markup" . $reply_markup;
	}
	$result = file_get_contents($call);
	return $result;
}
