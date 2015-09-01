<?php
$config->setDefault("image-src", "http://cravatar.eu/avatar/{NAME}/64");

$imageSrc = $config->get("image-src");

if (in_array($player->name,$plugin->onlinePlayers())){
    echo '<span class="label label-success">Online</span>';
}else{
    echo '<span class="label label-danger">Offline</span>';
}
