<?php
/**
 * Send a telegram message
 * 
 * calls the telegram Bot API to Send a Telegram message with the options given. Set the option in the array with help of the telegram Bot API reference
 * 
 * @param array $message The array with all options the telegram message object can have. 
 * @return json Result of the Bot-API call
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 * @see https://core.telegram.org/bots/api#sendmessage Fill the array with these option.
 */
function sendMessage($message){
	$chatID  					=	$message['chatID'];
	$text 	 					=	$message['text'];
	$parse_mode  				=	$message['parse_mode'];
	$disable_web_page_preview 	=	$message['disable_web_page_preview'];
	$disable_notification 	 	=	$message['disable_notification'];
	$reply_to_message_id  		=	$message['reply_to_message_id'];
	$reply_markup 	 			=	$message['reply_markup'];

	$call = TG_API_ROOT . "/sendMessage?chat_id=" . $chatID . "&text=" . urlencode($text);
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

/**
 * Send a telegram photo
 * 
 * calls the telegram Bot API to Send a Telegram photo with the options given. Set the option in the array with help of the telegram Bot API reference
 * 
 * @param array $message The array with all options the telegram photo object can have. 
 * @return json Result of the Bot-API call
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 * @see https://core.telegram.org/bots/api#sendphoto Fill the array with these option.
 */
function sendPhoto($message){
	$chatID  					=	$message['chatID'];
	$photo 	 					=	$message['photo'];
	$caption					=	$message['caption'];
	$parse_mode  				=	$message['parse_mode'];
	$disable_notification 	 	=	$message['disable_notification'];
	$reply_to_message_id  		=	$message['reply_to_message_id'];
	$reply_markup 	 			=	$message['reply_markup'];


	$call = TG_API_ROOT . "/sendPhoto?chat_id=" . $chatID . "&photo=" . $photo;
	if(isset($parse_mode)){
		$call .= "&parse_mode=" . $parse_mode;
	}
	if(isset($caption)){
		$call .= "&caption=" . $caption;
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