# Blue-Stats
Alternative Web Interface for the bukkit stats plugin my lolmewn

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
  
