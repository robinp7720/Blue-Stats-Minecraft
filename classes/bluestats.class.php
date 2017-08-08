<?php

class BlueStats {
    public $version    = "Beta 3.0";
    public $pluginName = "BlueStats";

    public $appPath  = "";
    public $viewPath = "";

    public $theme   = "material";
    public $page    = "home";
    public $plugins = [];
    public $config;
    public $mysqli;
    /** @var \BlueStats\API\plugin $basePlugin */
    public $basePlugin;
    public $url;
    public $formatter;

    public $request = [];

    function __construct ($mysqli, $appPath) {

        $this->setUpGlobals();
        $this->mysqli = $mysqli;

        // Initiate base config class
        $this->config = new config($mysqli, $this->pluginName);

        // Set default language for BlueStats - This needs to be here to upgrade older version. Can be safely removed
        $this->config->setDefault("language", "en_US");

        $this->theme = $this->config->get("theme");
        $this->page  = isset($this->request["get"]["page"]) ? $this->request["get"]["page"] : $this->config->get("homepage");

        $this->appPath = $appPath;
        $this->viewPath = $this->config->get("view_path");

        $this->url = new url($this->mysqli);
    }

    private function setUpGlobals () {
        foreach ($_GET as $key => $value) {
            $this->request["get"][$key] = urldecode($value);
        }
        foreach ($_POST as $key => $value) {
            $this->request["post"][$key] = urldecode($value);
        }
    }

    public function getPluginList () {
        return $this->config->get("plugins");
    }

    public function loadPlugins (array $plugins) {
        $this->plugins = $plugins;
        $baseplugin    = $this->config->get("base_plugin");

        if (isset($this->plugins[$baseplugin])) {
            $this->basePlugin = $this->plugins[$baseplugin];
        }
        else {
            echo "Base plugin does not exist: $baseplugin";
            echo "<br>Please install this plugin or change the base plugin";
        }

        // Setup formatter
        $this->formatter = new formatter($this);

    }

    public function loadPage () {
        $view = new view($this, $this->viewPath, $this->appPath);

        return $view->render();
    }

}
