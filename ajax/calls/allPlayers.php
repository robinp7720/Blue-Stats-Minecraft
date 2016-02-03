<?php
$base_plugin = $config->get("base_plugin");
$plugin = $plugins[$base_plugin];
$output['data'] = $plugin->getUsers(0, 10000, MYSQLI_NUM);