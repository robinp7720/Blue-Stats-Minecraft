<?php

class player
{
    public $exist = false;
    public $uuid = "";
    public $name = "";
    private $config;
    private $mysqli;
    private $base_plugin;
    private $bluestats;

    public function __Construct($bluestats, $uuid)
    {
        $this->mysqli = $bluestats->mysqli;
        $this->bluestats = $bluestats;

        $this->config = new config($this->mysqli, "Player");

        $this->base_plugin = $this->bluestats->base_plugin;
        $this->name = $this->base_plugin->getUserName($uuid);
        if (!empty($this->name)) {
            $this->uuid = $uuid;
            $this->exist = true;
            $this->getAllStats();
        } else {
            $this->name = "";
        }
    }

    public function getAllStats()
    {
        $output = "";
        foreach ($this->getMysqlPlugins() as $plugin) {
            if ($plugin->plugin["singleTable"]) {
                $output .= '<h1>'.$plugin->pluginName.'</h1>';
                foreach ($plugin->plugin["tables"] as $table) {
                    $stat = [];
                    $stat = $plugin->getStat($table, $this->uuid);
                    unset($stat[0][$plugin->plugin["idColumn"]]);

                    $output .= $this->render($table, $stat);
                }

            } else {
                $stat = [];
                foreach ($plugin->plugin["tables"] as $table) {
                    $statOut = $plugin->getStat($table, $this->uuid);
                    if (is_array($statOut)) {
                        $value = $statOut[$plugin->plugin["valueColumn"]];
                    } else {
                        $value = $statOut;
                    }
                    $stat[0][$table] = $value?: 0;
                    unset($stat[$plugin->plugin["idColumn"]]);
                }
                $output .= $this->render($plugin->pluginName, $stat,true);
            }
        }
        return $output;
    }

    public function getMysqlPlugins()
    {
        $mysqlPlugins = [];
        foreach ($this->bluestats->plugins as $plugin) {
            if ($plugin->mcPlugin) {
                $mysqlPlugins[] = $plugin;
            }
        }
        return $mysqlPlugins;
    }

    public function render($name, $stats,$h1=false)
    {
        if (!$h1)
            $output = '<h2>' . ucfirst($name) . '</h2><table class="table"><thead></thead><tbody>';
        else
            $output = '<h1>' . ucfirst($name) . '</h1><table class="table"><thead></thead><tbody>';

        foreach ($stats[0] as $key => $val) {
            $output .= '<tr><th>' . ucfirst($key) . '</th><td>' . $val . '</td></tr>';
        }
        $output .= '</tbody></table>';
        return $output;
    }
}