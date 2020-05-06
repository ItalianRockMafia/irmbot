<?php
/**
 *
 * @param string $apiURL The URL to make a get call to
 * @return mixed The result of the GET call
 *
 * @author Jonas Hüsser
 *
 *
 * @since 0.1
 */

function getCall($apiURL){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $apiURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return $response;
}
}
/**
 *
 * @param string $apiURL The URL to make a POST call to
 * @param string The string contains a JSON with the post body 
 * @return mixed The result of the POST call
 *
 * @author Jonas Hüsser
 *
 *
 * @since 0.1
 */
function postCall($apiURL, $postfields){


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $apiURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $postfields,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return $response;
}
}
/**
 *
 * @param string $apiURL The URL to make a PUT call to
 * @param string The string contains a JSON with the PUT body 
 * @return mixed The result of the PUT call
 *
 * @author Jonas Hüsser
 *
 *
 * @since 0.1
 */
function putCall($apiURL, $postfields) {
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $apiURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => $postfields,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return $response;
}}



/**
 *
 * @param string $apiURL The URL to make a DELETE call to
 * @return mixed The result of the DELETE call
 *
 * @author Jonas Hüsser
 *
 *
 * @since 0.1
 * 
 *  */
 function deleteCall($apiURL){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $apiURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "DELETE",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return $response;
}
}