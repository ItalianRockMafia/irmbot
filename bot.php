<?php
//comment
$token = require_once('token.php');
$lastfmToken = require_once('lastfm.php');
define("TG_API_ROOT", "https://api.telegram.org/bot" . $token);
define("IRM_API_ROOT","https://api.italianrockmafia.ch/api.php/");
define("LAST_API_ROOT", "http://ws.audioscrobbler.com/2.0/?");

require_once "functions/updates.php";
require_once "functions/telegram.php";
require_once "functions/irm.php";

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
			$response = "<b>All events:</b>" . chr(10) . chr(10);	
			$events = json_decode(file_get_contents(IRM_API_ROOT . "events?transform=1&order=startdate,asc"), true);
			foreach($events['events'] as $event){
				$date = new DateTime();

				$startdate = new DateTime($event['startdate']);
				$enddate = new DateTime($event['enddate']);
				$eventURL = "https://italianrockmafia.ch/meetup/event.php?event=" . $event['eventID'];
				if($startdate > $date && $enddate > $date){
					$response .= $event['event_title'] . chr(10);
					$response .= $startdate->format('d.m.Y H:i') . chr(10);
					$response .= $event['station'] . chr(10); 
					$response .= '<a href="' . $eventURL . '">View online</a>'. chr(10) . chr(10);
				}
				$msg2send['parse_mode'] = "HTML";
			}
		break;
		
		case stripos($msg, "/event") !== false:
			$res = explode(' ', $msg);
			$term = $res[1];
			$eventResults = json_decode(file_get_contents(IRM_API_ROOT . "events?transform=1&order=startdate,asc&filter=event_title,cs," . $term), true);
			$response = "<b>Found events:</b>" . chr(10) . chr(10);

			foreach($eventResults['events'] as $event){
			
				$date = new DateTime();
				$eventURL = "https://italianrockmafia.ch/meetup/event.php?event=" . $event['eventID'];

				$startdate = new DateTime($event['startdate']);
				$enddate = new DateTime($event['enddate']);
				if($startdate > $date && $enddate > $date){
					$response .= $event['event_title'] . chr(10);
					$response .= $startdate->format('d.m.Y H:i') . chr(10);
					$response .= $event['station'] . chr(10); 
					$response .= '<a href="' . $eventURL . '">View online</a>'. chr(10) . chr(10);
				}
				$msg2send['parse_mode'] = "HTML";
				}

		break;
		
		case stripos($msg, "/details") !== false:
			$arr = explode(' ', $msg);
			$eventID = $arr[1];
			$events = json_decode(file_get_contents(IRM_API_ROOT . "eventUsers?filter=eventID,eq," . $eventID . "&transform=1"), true);
			$eventDetails = "<b>Event details:</b>" . chr(10);
			foreach($events['eventUsers'] as $event){
				$startdate = new DateTime($event['startdate']);
				$enddate = new DateTime($event['enddate']);
				$eventDetails .= $event['event_title'] . chr(10);
				$eventDetails .= "Start: " . $startdate->format('d.m.Y H:i') .chr(10);
				$eventDetails .= "End:   " . $enddate->format('d.m.Y H:i') . chr(10);
				$eventDetails .= 'URL: <a href="' . $event['url'] . '">' . $event['url'] . '</a>' . chr(10);
				$eventDetails .= "Location: " . $event['station'] . chr(10);
				$eventDetails .= "Details:" .chr(10) . $event['description'] . chr(10);
				$eventDetails .= 'Creator: <a href="tg://user?id=' . $event['telegramID'] . '">' . $event['tgusername'] . '</a>'. chr(10) . chr(10);
			}
			$attMembers = json_decode(file_get_contents(IRM_API_ROOT . "eventAttendes?transform=1&filter=eventIDFK,eq," . $eventID), true);
			$attMsg = "<b>Attendes:</b>" . chr(10);
			foreach($attMembers['eventAttendes'] as $attende){
				$attMsg .= '<a href="tg://user?id=' . $attende['telegramID'] . '">' . $attende['firstname'] . ' ' . $attende['lastname'] . '</a>' . chr(10);
			}
			$response = $eventDetails . $attMsg;
			$msg2send['parse_mode'] = "HTML";
		break;

		case stripos($msg, "/getAlbum") !== false:
			$info = explode(' ', $msg);
			$album = $info[2];
			$artist = $info[1];
			$callurl = LAST_API_ROOT . "method=album.getinfo&api_key=" . $lastfmToken . "&album=" . $album . "&artist=" . $artist . "&format=json";
			$last_album = json_decode(file_get_contents($callurl), true);

			for ($i=0; $i < count($last_album['album']['image']); $i++) { 
				if($last_album['album']['image'][$i]['size'] == 'extralarge') {
					$largeImg = "";
					$largeImg = $last_album['album']['image'][$i]['#text']; 
				} 
			}
			  $response = "<b>Album " . $last_album['album']['name'] . " by " .  $last_album['album']['artist'] . '</b>' . chr(10) . chr(10) . "<i>Tracklist:</i>" . chr(10);
			  for ($i=0; $i < count($last_album['album']['tracks']['track']); $i++){
					$response .= $last_album['album']['tracks']['track'][$i]['name'] . chr(10);
			}
			$response .= '<a href="' . $last_album['album']['url'] . '">View online</a>';

			$pic2send['chatID'] = $message['chat']['id'];
			$pic2send['photo'] = $largeImg;
			$result = sendPhoto($pic2send);
			$msg2send['parse_mode'] = "HTML";
			$msg2send['disable_web_page_preview'] = true;
		break;
		
		case stripos($msg, "/server") !== false:
		if(checkBotAdmin($message['from']['id'])){

		
		$response = "<b>Server details:</b>" . chr(10) . chr(10);
			foreach($_SERVER as $key => $value){
				$response .= $key . ": " . strip_tags($value,'<a><b><i>') .chr(10);
			}
			$msg2send['parse_mode'] = "HTML";
			$msg2send['disable_web_page_preview'] = true;
		} else{
			$response = "Only a bot admin can do that";
		}

		break;

		case stripos($msg, "/ping") !== false:
			$response = "pong";
		break;
		
		case stripos($msg, "/echo") !== false:
			$split = explode(" ", $msg);
			$response = $split[1];
		break;
		
		case stripos($msg, "/quit") !== false:
			if(checkBotAdmin($message['from']['id'])){
				$bot_is_running = false;
			}else{
				$response = "Only a bot admin can do that";
			}
		break;
	}
} else{

switch (true) {
	case stripos($msg, "Bier") !== false:
	case stripos($msg, "bier") !== false:
		$response = "🍻";
		break;
	case stripos($msg, "🍻") !== false:
			$response = "🍻🍻🍻";
			break;
	case stripos($msg, "Schnupf") !== false:
		$response = "Priiiiis!!";
		break;
	case stripos($msg, "schnupf") !== false:
		$response = "I de Migros gits alles zum halbe Priiis!";
		break;
	/* case stripos($msg, "Feldschlössli") !== false:
	case stripos($msg, "Feldi") !== false:
	case stripos($msg, "feldi") !== false:
		$response = urlencode("#TeamMüller");
		break;
	case stripos($msg, "Müller") !== false:
	case stripos($msg, "müller") !== false:
		$response = urlencode("#TeamFeldi");
		break; */
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
	/*case stripos($msg, "hüsser") !== false:
		$response = urlencode("De Hüsser isch wie en Vater für mich...");
		*/
	break;
	case stripos($msg, "metal monday") !== false:
		$response = "🤘🤘🤘 mentig, 18:30, werkk bade 🤘🤘🤘";
		break;
	
	
	default:
		# code...
		break;
}
}

if(checkBotAccess($message['from']['id'])){
	$msg2send['chatID'] = $message['chat']['id'];
	$msg2send['text'] = $response;
} else {
	$msg2send['chatID'] = $message['from']['id'];
	$msg2send['text'] = "You're banned from using this bot.";
}


$result = sendMessage($msg2send);
