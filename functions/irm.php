<?php
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

