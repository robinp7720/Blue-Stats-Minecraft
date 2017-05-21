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
        $this->name = $this->basePlugin->player->getName($this->basePlugin->player->getID($player));
        if (!empty($this->name)) {
            $this->uuid = $player;
            $this->exist = true;
        } else {
            $this->uuid = $this->basePlugin->player->getUUID($this->basePlugin->player->getID($player));
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
        /** @var \BlueStats\API\plugin $plugin */
        foreach ($this->bluestats->plugins as $plugin) {
            $output .= "<h3>$plugin->name</h3>";
            foreach ($plugin->database['stats'] as $stat => $info) {
                $statName = $plugin->database["stats"][$stat]["name"];
                $output .= "<h4>$statName</h4>";
                $table = New Table();
                // Loop through all values in database
                $data = $plugin->stats->player($plugin->player->getUUID($plugin->player->getID("206d307c-ef43-45b0-aa77-3511e13df2f1")), $stat);
                foreach ($data as $key => $entry) {
                    $values = [];
                    foreach ($entry as $statt => $value) {
                        array_push($values, $value);
                    }
                    call_user_func_array([$table, 'addRecord'], $values);
                }

                // Generate header for table
                $values = [];

                foreach ($plugin->database["stats"][$stat]["values"] as $entry) {
                    array_push($values, $entry["name"]);
                }
                call_user_func_array([$table, 'makeHeader'], $values);
                $output .= $table->tableToHTML();
            }
        }

        return $output;
    }


}