<?php
require __DIR__ . "/minecraftQuery.php";
$plugins["query"] = new onlinePlayers($mysqlMan->get("BlueStats"));