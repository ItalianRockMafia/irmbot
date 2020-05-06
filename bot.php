<?php
$config = require_once 'config.php';
require_once 'functions/apicalls.php';

$tg_api = "https://api.telegram.org/bot" . $config->token;
$update = json_decode(file_get_contents("php://input"), TRUE);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

if (stripos($message, "/ping") === 0) {
    $msg = "pong";

}

if (stripos($message, "bier") !== false){
    $msg = "🍻";

}

if (stripos($message, "/event") === 0) {
    if ($update['chat']['type'] == "private") {
        $eventTitle = substr($message, 7);
        $eventMsg = "Event Title: " . $eventTitle .chr(10);
        $keyboard = array();
        $keyboard['InlineKeyboardMarkup'] = array();
        $keyboard['InlineKeyboardMarkup']['text'] = "test";

        $callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($eventMsg) . "&reply_markup=" . $keyboard;

    } else {
        $msg = "Please use this command in private.";
    }

}

$callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

$sentMessage = json_decode(getCall($callURL), true);