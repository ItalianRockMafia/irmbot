<?php
/**
 * check if a IRM-User has access to the bot
 * 
 * Bot access is saved in the IRM-DB. This function checks if a user is allowed to interact with the bot.
 * 
 * @param string $tgID the telegram ID of the user to be checked.
 * @return bool Access to the bot
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 * 
 */
function checkBotAccess($tgID){
	$users = json_decode(file_get_contents(IRM_API_ROOT . "users?transform=1&filter=telegramID,eq," . $tgID), true);
	foreach($users['users'] as $user){
		switch($user['accessIDFK']){
			case 1:
			case 2:
			case 3:
				return false;
			break;
			case 4:
			case 5:
			case 6:
			case 7:
				return true;
		}
	}
}

/**
 * check if a IRM-User has mod access to the bot
 * 
 * Bot access is saved in the IRM-DB. This function checks if a user is allowed to interact with the bot as a moderator.
 * 
 * @param string $tgID the telegram ID of the user to be checked.
 * @return bool mod access to the bot
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 * 
 */
function checkBotMod($tgID){
	$users = json_decode(file_get_contents(IRM_API_ROOT . "users?transform=1&filter=telegramID,eq," . $tgID), true);
	foreach($users['users'] as $user){
		switch($user['accessIDFK']){
			case 1:
			case 2:
			case 3:
			case 4:
				return false;
			break;

			case 5:
			case 6:
			case 7:
				return true;
		}
	}
}


/**
 * check if a IRM-User has admin access to the bot
 * 
 * Bot access is saved in the IRM-DB. This function checks if a user is allowed to interact with the bot with admin privileges.
 * 
 * @param string $tgID the telegram ID of the user to be checked.
 * @return bool admin access to the bot
 * @author Jonas Huesser <j.huesser@domayntec.ch>
 * @since 0.1
 * 
 */
function checkBotAdmin($tgID){
	$users = json_decode(file_get_contents(IRM_API_ROOT . "users?transform=1&filter=telegramID,eq," . $tgID), true);
	foreach($users['users'] as $user){
		switch($user['accessIDFK']){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				return false;
			break;
			
			case 6:
			case 7:
				return true;
		}
	}
}

