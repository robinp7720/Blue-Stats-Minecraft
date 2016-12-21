<?php

class player
{
    public $exist = false;
    public $uuid = "";
    public $name = "";
    private $config;
    private $mysqli;
    private $basePlugin;
    private $bluestats;

    public function __Construct($bluestats, $player)
    {
        $this->mysqli = $bluestats->mysqli;
        $this->bluestats = $bluestats;

        $this->config = new config($this->mysqli, "Player");

        $this->basePlugin = $this->bluestats->basePlugin;
        $this->name = $this->basePlugin->getUserName($player);
        if (!empty($this->name)) {
            $this->uuid = $player;
            $this->exist = true;
        } else {
            $this->uuid = $this->basePlugin->getUUID($player);
            if (!empty($this->uuid)) {
                $this->name = $player;
                $this->exist = true;
            } else {
                $this->name = NULL;
                $this->uuid = NULL;
                $this->exist = false;
            }
        }
    }

    public function renderPlayerAllStats()
    {
        $output = "";
        foreach ($this->getMysqlPlugins() as $plugin) {
            if ($plugin->plugin["singleTable"]) {
                $output .= '<h2>' . ucfirst($plugin->pluginName) . '</h2>';
                foreach ($plugin->plugin["tables"] as $table) {
                    $stat = $plugin->getStat($table, $this->uuid);
                    unset($stat[0][$plugin->plugin["idColumn"]]);

                    $output .= $this->render($table, $stat);
                }

            } else {
                $stat = [];
                foreach ($plugin->plugin["tables"] as $table) {
                    $statOut = $plugin->getStat($table, $this->uuid);
                    if (is_array($statOut)) {
                        if (isset($statOut[$plugin->plugin["valueColumn"]])) {
                            $value = $statOut[$plugin->plugin["valueColumn"]];
                        }
                    } else {
                        $value = $statOut;
                    }
                    $stat[0][$table] = $value ?: 0;
                    unset($stat[$plugin->plugin["idColumn"]]);
                }
                $output .= $this->render($plugin->pluginName, $stat, true);
            }
        }
        return $output;
    }

    public function getMysqlPlugins()
    {
        $mysqlPlugins = [];
        foreach ($this->bluestats->plugins as $plugin) {
            if ($plugin->mcPlugin && $plugin->display_in_playerstats === "true") {
                $mysqlPlugins[] = $plugin;
            }
        }
        return $mysqlPlugins;
    }

    public function render($name, $stats, $h2 = false)
    {
        $tableid = uniqid();
        if (!$h2)
            $output = '<h3>' . ucfirst($name) . '</h3><table class="table" id="' . $tableid . '"><thead><tr><th>Stat</th><td>Value</td></tr></thead><tbody>';
        else
            $output = '<h2>' . ucfirst($name) . '</h2><table class="table" id="' . $tableid . '"><thead><tr><th>Stat</th><td>Value</td></tr></thead><tbody>';

        foreach ($stats[0] as $key => $val) {
            $output .= '<tr><td>' . ucfirst(str_replace(array("-", "_"), " ", $key)) . '</td><td>' . $val . '</td></tr>';
        }
        $output .= '</tbody></table>';
        $output .= "<script>
    $(document).ready(function () {
        $('#$tableid').DataTable();
    });
</script>";
        return $output;
    }
}