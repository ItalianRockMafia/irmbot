<?php
/**
 * Get new messages
 * 
 * calls the telegram Bot API to get all new updates.
 * 
 * @param string $offset The latest update the bot has received.
 * @return json All new updates
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 */
function getUpdates($offset){
	global $token;
	$start = date("Y-m-d h:i:s");
	$updates = file_get_contents("https://api.telegram.org/bot" . $token . "/getUpdates?timeout=60&offset" . $offset);
	$end = date("Y-m-d h:i:s");
	$msg = "Start: " . $start . " End: " . $end;
	file_put_contents("log.txt", $msg, FILE_APPEND);
	$updates = json_decode($updates, true);
	$data = $updates['result'];
	$lastNMB = count($data)-1;
	$update= $data[$lastNMB];

	return $update;
}