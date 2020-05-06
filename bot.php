<?php
$config = require_once 'config.php';
require_once 'functions/apicalls.php';

$tg_api = "https://api.telegram.org/bot" . $config->token;
$update = json_decode(file_get_contents("php://input"), TRUE);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

if (strpos($message, "/ping") === 0) {
    $msg = "pong";

    $callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);
    $apicall = json_decode(getCall($callURL), true);
}

if (strpos($message, "bier") !== false || strpos($message, "Bier") !== false){
    $callURL = $tg_api . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode("prost");
    $apicall = json_decode(getCall($callURL), true);


}