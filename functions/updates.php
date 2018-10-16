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
	$updates = file_get_contents("https://api.telegram.org/bot" . $token . "/getUpdates?offset" . $offset);
	$updates = json_decode($updates, true);
	$data = $updates['result'];
	$lastNMB = count($data)-1;
	$update= $data[$lastNMB];

	return $update;
}