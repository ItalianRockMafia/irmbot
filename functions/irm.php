<?php
function checkBotAccess($tgID) {
    global $config;
    $callURL = $config->api_url . "/users?transform=1&filter=telegramID,eq," . $tgID;
    $users = json_decode(file_get_contents($callURL), true);

    switch ($users['users'][0]['accessIDFK']) {
        case '1':
        case '2':
        case '3':
            $access = false;
            break;
        case '4':
        case '5':
        case '6':
        case '7':
            $access = true;
            break;

       
        default:
            $access = false;
            break;
    }

    return $access;
}

function checkBotAdminAccess($tgID){
    global $config;
    $callURL = $config->api_url . "/users?transform=1&filter=telegramID,eq," . $tgID;
    $users = json_decode(file_get_contents($callURL), true);

    switch ($users['users'][0]['accessIDFK']) {
        case '1':
        case '2':
        case '3':
        case '4':
        case '5':
            $access = false;
        break;
        case '6':
        case '7':
            $access = true;
            break;
        default:
            $access = false;
        break;
    }
    return $access;

}

function getIRMUserPropertiesByTelegramID($tgID){
    global $config;
    $callURL = $config->api_url . "/users?transform=1&filter=telegramID,eq," . $tgID;
    $user = json_decode(file_get_contents($callURL), true);
    return $user['users']['0'];
}

function getPlexSubscribers(){
    global $config;
    $callURL  = $config->api_url . "/users?transform=1&filter=plexSubscriber,eq,1";
    $subscribers = json_decode(file_get_contents($callURL), true);
    return $subscribers["users"];
}