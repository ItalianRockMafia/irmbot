<?php
$config = require_once 'config.php';
require_once 'functions/apicalls.php';
require_once 'functions/irm.php';

$tg_api = "https://api.telegram.org/bot" . $config->token;
$update = json_decode(file_get_contents("php://input"), TRUE);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
$senderID = $update["message"]["from"]["id"];


if (stripos($message, "/ping") === 0) {
    $msg = "pong";

}

if (stripos($message, "/getMyID") === 0){
	$msg = "Your telegram ID is: " . $senderID;
}

if (stripos($message, "/subPlexUpdates") === 0){
	$access = checkBotAccess($senderID);
    if($access){
        $postfields = "{\n\t\"plexSubscriber\": 1\n\t\n}";
        $IRMUser = getIRMUserPropertiesByTelegramID($senderID);
        $usersURL = $config->api_url . "/users/" . $IRMUser['userID'];
       $plexUpdateSuccess = putCall($usersURL, $postfields);
       if(is_numeric($plexUpdateSuccess)) {
           $msg = "Your Plex Update Subscription is registred.";
       } else {
           $msg = "There was an error registring your plex subscription preference.";
       }
    } else {
        $msg = "Please register yourself at https://italianrockmafia.ch first. Thanks.";
    }
}

if (stripos($message, "/unsubPlexUpdates") === 0){
	$access = checkBotAccess($senderID);
    if($access){
        $postfields = "{\n\t\"plexSubscriber\": 0\n\t\n}";
        $IRMUser = getIRMUserPropertiesByTelegramID($senderID);
        $usersURL = $config->api_url . "/users/" . $IRMUser['userID'];
       $plexUpdateSuccess = putCall($usersURL, $postfields);
       if(is_numeric($plexUpdateSuccess)) {
           $msg = "Your Plex Update Subscription is removed.";
       } else {
           $msg = "There was an error removing your plex subscription preference.";
       }
    } else {
        $msg = "Please register yourself at https://italianrockmafia.ch first. Thanks.";
    }
}

if (stripos($message, "/publishPlexUpdate") !== false){
    $AdminAccess = checkBotAdminAccess($senderID);
    if($AdminAccess) {
    $IMDBID = substr($message, strpos($message, " ") + 1);
    $callURL = $config->imdb["api_url"] . "Title/" . $config->imdb['token'] . "/" . $IMDBID . "/Posters,Trailer";
    $movieInfo = json_decode(file_get_contents($callURL), true);

    switch ($movieInfo['type']) {
        case 'Movie':
            $type = "movie";
        break;
        case "TVSeries":
            $type = "series";
        break;
        default:
            $type = "media";
        break;

    }



    $captionString = "<b>New " . $type . " added to Plex!</b>" . chr(10) . chr(10) . 
    "Name: " . $movieInfo['title'] . " (" . $movieInfo['year'] . ")". chr(10) . 
    "Runtime: " . $movieInfo['runtimeStr'] . chr(10) .
    "Starring: " . $movieInfo['stars'] . chr(10) . 
    "Genres: " . $movieInfo['genres'] . chr(10) . chr(10) . 
    '<a href="' .  $movieInfo['trailer']['link'] . '">View trailer</a>';

    $subscribers = getPlexSubscribers();
    $Plotmsg = "<b>Plot:</b> " . $movieInfo['plot'];
    foreach ($subscribers as $subscriber) {
        $callURL = $tg_api . "/sendPhoto?chat_id=" . $subscriber['telegramID'] . "&caption=" . urlencode($captionString) . "&parse_mode=HTML&photo=" . $movieInfo['image'];
        $sentMessage = json_decode(getCall($callURL), true);
        $callURL = $tg_api . "/sendMessage?chat_id=" . $subscriber['telegramID'] . "&parse_mode=HTML&text=" . urlencode($Plotmsg);

        $sentMessage = json_decode(getCall($callURL), true);

    }

    

    
    } else {
        $msg = "No access";
    }
}

if (stripos($message, "bier") !== false){
    $responses = array("🍻", "🍺", "Prost!");
    $msg = $responses[array_rand($responses)];

}

if (stripos($message, "/music") === 0 ){
    $lastfm_user = substr($message, 7);
    $msg = "Which details from user " . $lastfm_user . " do you want to display?";
    $keyboard = array();
        $keyboard['inline_keyboard'] = array();
        $keyboard['inline_keyboard'][0] = array();
        $keyboard['inline_keyboard'][0][0]['text'] = "Weekly top songs";
        $keyboard['inline_keyboard'][1] = array();
        $keyboard['inline_keyboard'][1][0]['text'] = "Monthly top songs";
}

if (stripos($message, "/event") === 0) {
    if ($update['message']['chat']['type'] == "private") {
        $eventTitle = substr($message, 7);
        $eventMsg = "Event Title: " . $eventTitle .chr(10);



        
        $keyboard = array();
        $keyboard['inline_keyboard'] = array();
        $keyboard['inline_keyboard'][0] = array();
        $keyboard['inline_keyboard'][0][0]['text'] = "Set start time";
        $keyboard['inline_keyboard'][0][0]['login_url'] = array();
        $keyboard['inline_keyboard'][0][0]['login_url']['url'] = "https://italianrockmafia.ch/check.php?r=https://italianrockmafia.ch/meetup";
        $keyboard['inline_keyboard'][0][0]['login_url']['bot_username'] = "irmbot";
        $keyboard['inline_keyboard'][0][0]['login_url']['request_write_access'] = true;


       
    $buttons = json_encode($keyboard);
        

        $callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($eventMsg) . "&reply_markup=" . urlencode($buttons);
        file_get_contents($callURL);

    } else {
        $msg = "Please use this command in private.";
    }

}

$callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&parse_mode=HTML&text=" . urlencode($msg);

$sentMessage = json_decode(getCall($callURL), true);
