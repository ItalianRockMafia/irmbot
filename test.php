<?php

declare(strict_types = 1);

include __DIR__.'/vendor/autoload.php';

define('BOT_TOKEN', '179948695:AAFbyA1w_CuUfcTy494gQt3hg-_10SCmNvw');

use React\EventLoop\Factory;
use \unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\GetMe;
use unreal4u\TelegramAPI\TgLog;

$loop = Factory::create();
$tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));
$response = Clue\React\Block\await($tgLog->performApiRequest(new GetMe()), $loop);
var_dump($response);
