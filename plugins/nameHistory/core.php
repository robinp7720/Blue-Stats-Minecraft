<?php
class nameHistory extends plugin{
    public $pluginName = "nameHistory";
    public function getNames($uuid){
        $uuid = str_replace("-","",$uuid);
        return json_decode(file_get_contents("https://api.mojang.com/user/profiles/$uuid/names"),true);
    }
}