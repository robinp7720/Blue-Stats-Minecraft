<?php

class BlueStats
{
    public $version = "Beta 3.0";
    public $pluginName = "BlueStats";
    public $appPath = "";
    public $theme;
    public $page = "home";
    public $plugins;
    public $config;
    public $mysqli;

    private $request = [];

    function __construct($mysqli, $appPath)
    {
        $this->setUpGlobals();
        $this->mysqli = $mysqli;

        $this->config = new config($mysqli, $this->pluginName);
        $this->config->setDefault("plugins", array("lolmewnStats", "query", "themeText"));
        $this->config->setDefault("server-name", "A Minecraft Server");
        $this->config->setDefault("theme", "default");
        $this->config->setDefault("base_plugin", "lolmewnStats");
        $this->config->setDefault("view_path", "$appPath/themes/{THEME}/");
        $this->config->setDefault("homepage", "home");

        $this->theme = $this->config->get("theme");
        $this->page = isset($this->request("get")["page"])? $this->request("get")["page"] : $this->config->get("homepage");

        $this->appPath = $appPath;
    }

    private function setUpGlobals()
    {
        foreach ($_GET as $key => $value) {
            $this->request["get"][$key]=urldecode($value);
        }
        foreach ($_POST as $key => $value) {
            $this->request["post"][$key]=urldecode($value);
        }
    }

    public function request($type)
    {
        return $this->request[$type];
    }

    public function getPluginList()
    {
        return $this->config->get("plugins");
    }

    public function loadPlugins(array $plugins)
    {
        $this->plugins = $plugins;
    }

    public function loadPage()
    {
        $view = new view($this, $this->config->get("view_path"), $this->appPath);
        return $view->render();
    }

}