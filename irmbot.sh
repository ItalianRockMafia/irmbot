#!/bin/bash
token=$(<token.txt)
offset=$(<latest.txt)
updates="`wget --quiet \
  --method GET \
  --header 'cache-control: no-cache' \
  --header 'Postman-Token: a96e850e-38d1-45b3-afd7-f99f7d2b6e26' \
  --output-document \
  - https://api.telegram.org/bot$token/getUpdates/?offset=$offset`"

wget -q \
 	--method POST \
	#--header 'Content-Type: application/json' \
	--header 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
	--header 'Content-Type: application/x-www-form-urlencoded' \
	--header 'cache-control: no-cache' \
	--body-data '------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name="updates" $updates ------WebKitFormBoundary7MA4YWxkTrZu0gW--' \
	#--body-data "$updates" \
	--output-document \
	- http://localhost/irmbot/bot.php
