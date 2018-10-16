# irmbot
IRM telegram bot

# Installation
clone this repo to your www root
create token.php with this content:
```php
<?php
return "your-telegram-bot-api-token";
```

create lastfm.php with this content:
```php
<?php
return "your-last-fm-api-token";
```
touch latest.txt with *write* access for the web user (eg www-data)

Load `bot.php` every now or then. (for example every second):

```bash
watch -n1 "wget --spider -q http://localhost/irmbot/bot.php"
```
