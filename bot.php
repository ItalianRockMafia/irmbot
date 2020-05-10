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

if (stripos($message, "bier") !== false){
    $msg = "🍻";

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

$callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

$sentMessage = json_decode(getCall($callURL), true);