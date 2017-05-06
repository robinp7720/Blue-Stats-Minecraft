<?php

class themeText extends plugin
{
    public $pluginName = "theme text";
    public $texts = [];

    public function onLoad()
    {
        $this->texts["server-name"] = $this->config->get("server-name", "BlueStats");
        $this->texts["page-name"] = isset($_GET['page'])? $_GET['page'] : "home";
    }
}