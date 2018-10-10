<?php

function getUpdates(){
	global $token;
	$updates = file_get_contents("https://api.telegram.org/bot" . $token . "/getUpdates");
	$updates = json_decode($updates, true);
	$data = $updates['result'];
	$lastNMB = count($data)-1;
	$update= $data[$lastNMB];

	return $update;
}