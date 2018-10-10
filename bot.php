<?php

$token = require_once('token.php');
define("TG_API_ROOT", "https://api.telegram.org/bot" . $token);
define("IRM_API_ROOT","https://api.italianrockmafia.ch/api.php/");

require_once "functions/updates.php";
require_once "functions/telegram.php";

$username = "irmbot";
$latest = file_get_contents("latest.txt");


$update = getUpdates($latest);

if($latest == $update['update_id']){
	exit("No new updates.");
}
file_put_contents("latest.txt", $update['update_id']);


$message = $update['message'];
$msg = $message['text'];

if($msg[0] == "/"){
	switch (true){
		case stripos($msg, "/events") !== false:
		$response = "<b>All events:<b>" . chr(10) . chr(10);	
		$events = json_decode(file_get_contents(IRM_API_ROOT . "events?transform=1&order=startdate,asc"), true);
			foreach($events['events'] as $event){
				$date = new DateTime();

				$startdate = new DateTime($event['startdate']);
				$enddate = new DateTime($event['enddate']);
				$eventURL = "https://italianrockmafia.ch/meetup/event/" . $event['eventID'];
				if($startdate > $date && $enddate > $date){
					$response .= $event['event_title'] . chr(10);
					$response .= $startdate->format('d.m.Y H:i') . chr(10);
					$response .= $event['station'] . chr(10); 
					$response .= '<a href="' . $eventURL . '">View online</a>'. chr(10) . chr(10);
				}
				$msg2send['parse_mode'] = "HTML";
			}
			break;
		
	}
} else{

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
}
$msg2send['chatID'] = $message['chat']['id'];
$msg2send['text'] = $response;

$result = sendMessage($msg2send);

