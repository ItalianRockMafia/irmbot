#!/bin/bash
token=$(<token.txt)
offset=$(<latest.txt)
updates="`wget -qO- https://api.telegram.org/bot{$token}/getUpdates&offset=$offset`"

wget -q \
 	--method POST \
	--header 'Content-Type: application/json' \
	--header 'cache-control: no-cache' \
	--body-data '$updates' \
	--output-document \
	- http://localhost/irmbot/bot.php
