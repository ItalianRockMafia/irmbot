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


$callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

$sentMessage = json_decode(getCall($callURL), true);