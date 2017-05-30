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

    private $renderChart = false;
    private $maxPerChart= 5;

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

        $this->config->setDefault("charts", "false");
        $this->config->setDefault("statsPerGraph", 5);

        if ($this->config->get("charts") === "true") {
            $this->renderChart = true;
        }

        $this->maxPerChart = $this->config->get("statsPerGraph");

        foreach ($this->getMysqlPlugins() as $plugin) {
            if ($plugin->plugin["singleTable"]) {
                $output .= '<h2>' . ucfirst($plugin->pluginName) . '</h2>';
                foreach ($plugin->plugin["tables"] as $table) {
                    $stat = $plugin->getStat($table, $this->uuid);
                    unset($stat[0][$plugin->plugin["idColumn"]]);

                    $output .= $this->render($table, $stat, false, $plugin);
                }

            } else {
                $stat = [];
                foreach ($plugin->plugin["tables"] as $table) {
                    $value = 0;
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
                $output .= $this->render($plugin->pluginName, $stat, true, $plugin);
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

    public function render($name, $stats, $h2 = false, $plugin)
    {
        if ($this->renderChart) {
            $chart = new chart();
            $chart->setType("bar");
        }
        $tableid = uniqid();

        $graphOut = "";
        $count = 0;

        if (!$h2)
            $output = '<h3>' . ucfirst($name) . '</h3><table class="table table-sorted" id="' . $tableid . '"><thead><tr><th>Stat</th><td>Value</td></tr></thead><tbody>';
        else
            $output = '<h2>' . ucfirst($name) . '</h2><table class="table table-sorted" id="' . $tableid . '"><thead><tr><th>Stat</th><td>Value</td></tr></thead><tbody>';

        foreach ($stats[0] as $key => $val) {
            if ($h2)
                $label = ucfirst(str_replace(array("-", "_"), " ", $key));
            elseif (method_exists($plugin,"statName"))
                $label = $plugin->statName($key);
            else
                $label = ucfirst(str_replace(array("-", "_"), " ", $key));


            if (is_numeric($val) && $this->renderChart) {
                $chart->addLabel($label);
                $chart->addData($label, $val);
                $count += 1;
                if ($count == $this->maxPerChart) {
                    $count = 0;
                    $graphOut .= $chart->render();
                    $chart = new chart();
                    $chart->setType("bar");
                }
            }
            $output .= "<tr><td>$label</td><td>$val</td></tr>";
        }
        $output .= '</tbody></table>';
        $output .= "<script>$(document).ready(function () {
        $('#$tableid').DataTable();
    });
</script>";
        if ($this->renderChart)
            $graphOut .= $chart->render();
        return $output.$graphOut;
    }

}