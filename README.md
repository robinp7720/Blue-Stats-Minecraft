# Blue-Stats
Alternative Web Interface for the bukkit stats plugin my lolmewn
Demo: http://stats.mysunland.org/

How to install
==============
Move all files and folders to your webserver files. Then navigate to configs/ and edit general.php, mysql.php and server.php

General.php
--------------
Edit the following lines to suit your needs:
```
$site_base_url = "www.example.com"; Make this the webserver root. All lines will use this as a prefix if url_rewrite is enabled
$enable_url_rewrite = true; If Url reqrite should be used
```

Mysql.php
--------------
Edit the following lines to suit your needs:
```
"host" => "localhost", Your MySql Host and port
"username" => "minecraft", Your MySql username
"password" => "password", Password for username
"dbname" => "minecraft", Database name
"table_prefix" => "Stats_" Table prefix
```

Server.php
--------------
Edit the following lines to suit your needs:
```
"ip" => "127.0.0.1", Minecraft server ip
"port" => "25565", Minecraft server port
"query_enabled" => true, Enable MC query?
"server_name" => "A Minecraft Server", Text to show in tab bar
```

Support
==============
If you need any help, found a bug or have an idea for this webappp, please create an issue for it. I will only support unmodified versions of this web app. This excudes of course, changing the config files.

LICENSE
==============
This open source web app is released under
Attribution-NonCommercial-ShareAlike 4.0 International license with the following notices.
Removing, changing or obsucating the title text and footer text is a violation to this license. You may NOT change any link directing to this github repo or to the forums post for BlueStats on the bukkit forums. You may NOT remove, change or obsucate my name (_OvErLoRd_) on any part of this web app.


