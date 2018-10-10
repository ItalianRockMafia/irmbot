<?php

$token = require_once('token.php');
define("TG_API_ROOT", "https://api.telegram.org/bot" . $token);

require_once "functions/updates.php";
require_once "functions/telegram.php";

$username = "irmbot";

$update = getUpdates();

$latest = file_get_contents("latest.txt");
if($latest == $update['update_id']){
	exit("No new updates.");
}
file_put_contents("latest.txt", $update['update_id']);


$message = $update['message'];
$msg = $message['text'];

switch (true) {
	case stripos($msg, "Bier") !== false:
	case stripos($msg, "bier") !== false:
		$response = "🍻";
		break;
	case stripos($msg, "Schnupf") !== false:
		$response = "Priiiiis!!";
		break;
	case stripos($msg, "schnupf") !== false:
		$response = "I de Migros gits alles zum halbe Priiis!";
		break;
	case stripos($msg, "Feldschlössli") !== false:
	case stripos($msg, "Feldi") !== false:
	case stripos($msg, "feldi") !== false:
		$response = "#TeamMüller";
		break;
	case stripos($msg, "Müller") !== false:
	case stripos($msg, "müller") !== false:
		$response = "#TeamFeldi";
		break;
	case stripos($msg, "Chopfab") !== false:
	case stripos($msg, "chopfab") !== false:
		$response = "🍻";
		break;
	case stripos($msg, "Schüga") !== false:
	case stripos($msg, "schüga") !== false:
		$response = "Gahn weg...";
		break;
	case stripos($msg, "Schüga") !== false:
	case stripos($msg, "schüga") !== false:
		$response = "Gahn weg...";
		break;
	case stripos($msg, "irony") !== false:
	case stripos($msg, "Irony") !== false:
	case stripos($msg, "iof") !== false:
	case stripos($msg, "IoF") !== false:
		$response = "Wenn simemer endli da?";
		break;
	case stripos($msg, "Schlager") !== false:
	case stripos($msg, "schlager") !== false:
		$response = "Untermusig!";
		break;
	case stripos($msg, "Rock") !== false:
	case stripos($msg, "rock") !== false:
		$response = "In rock we trust, it's rock or bust!";
		break;		
	case stripos($msg, "Moretti") !== false:
	case stripos($msg, "morretti") !== false:
		$response = "Una biera avec le family 🍻";
		break;
	case stripos($msg, "Hüsser") !== false:
	case stripos($msg, "hüsser") !== false:
		$response = "De Hüsser isch wie en Vater für mich...";
		break;
	
	
	default:
		# code...
		break;
}

$msg['chatID'] = $message['chat']['id'];
$msg['text'] = $response;

$result = sendMessage($msg);

//file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $message['chat']['id'] . "&text=" . $response);
