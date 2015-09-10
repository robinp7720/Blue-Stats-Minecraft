<?php

class module
{
    private $pluginName;
    private $moduleName;
    private $plugin;
    private $theme;
    private $appPath;

    private $player;

    private $config;
    private $args = [];

    private $url;

    public function __Construct($mysqli, $pluginN, $moduleN, $plugin, $theme, $appPath, $url, $args = "", $player)
    {
        $this->plugin = $plugin;
        $this->pluginName = $pluginN;
        $this->moduleName = $moduleN;
        $this->theme = $theme;
        $this->appPath = $appPath;

        $this->url = $url;

        $this->args[0] = $args;
        if (isset($player)) {
            $this->player = $player;
        }


        $this->config = new config($mysqli, "MODULE__" . $this->pluginName . "___" . $this->moduleName);
    }

    public function render()
    {
        $player = $this->player;
        $url = $this->url;

        /** @noinspection PhpUnusedLocalVariableInspection */
        $plugin = $this->plugin;
        $pluginN = $this->pluginName;
        $moduleN = $this->moduleName;

        /** @noinspection PhpUnusedLocalVariableInspection */
        $config = $this->config;
        /** @noinspection PhpUnusedLocalVariableInspection */
        $args = $this->args;

        /* Replace key with module */
        ob_start();
        if (file_exists($this->appPath . "/plugins/{$pluginN}/modules/" . $moduleN . ".php")) {
            include($this->appPath . "/plugins/{$pluginN}/modules/" . $moduleN . ".php");
        } elseif (file_exists($this->appPath . "/themes/{$this->theme}/modules/{$pluginN}/{$moduleN}.php")) {
            /** @noinspection PhpIncludeInspection */
            include($this->appPath . "/themes/{$this->theme}/modules/{$pluginN}/{$moduleN}.php");
        } else {

        }
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

}