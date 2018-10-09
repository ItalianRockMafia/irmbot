<?php

$token = require_once('token.php');
require_once "functions/updates.php";
$username = "irmbot";

$update = getUpdates();

$message = $update['message'];
$msg = $message['text'];

switch (true) {
	case stripos($msg, "Bier") !== false:
	case stripos($msg, "bier") !== false:
		$response = "🍺";
		break;
	
	default:
		# code...
		break;
}

file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $message['chat']['id'] . "&text=" . $response);