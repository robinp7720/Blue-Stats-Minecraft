<?php

class player
{
    public $exist = false;
    public $uuid = "";
    public $name = "";
    private $config;
    private $mysqli;
    /** @var \BlueStats\API\plugin $basePlugin */
    private $basePlugin;

    /** @var BlueStats $bluestats */
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
        $blocks_names = json_decode(file_get_contents($this->bluestats->appPath."/items.json"),true);

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
                    $count = 0;
                    $itemID = 0;
                    foreach ($entry as $statt => $value) {
                        switch ($plugin->database["stats"][$stat]["values"][$count]["dataType"]){
                            case "item_id":
                                // If the data collected was of type item_id, store it and wait until the data type is received.
                                $itemID = $value;
                                break;
                            case "item_type":
                                $name = getBlockNameFromID($itemID, $value, $blocks_names);
                                if (!$name)
                                    $name = getBlockNameFromID($itemID, 0, $blocks_names);
                                if ($name)
                                    $name .= " ($itemID-$value)";
                                if (!$name)
                                    $name = $itemID . "-". $value;
                                array_push($values, $name);
                                break;
                            case "player_name":
                                if ($this->bluestats->url->useUUID) {
                                    $uuid = $this->basePlugin->player->getUUIDfromName($value);
                                    $value = "<a href=\"" . $this->bluestats->url->player($uuid) . "\"><img src=\"https://minotar.net/helm/{$value}/32.png\" alt=\"\"> {$value}</a>";
                                } else {
                                    $value = "<a href=\"" . $this->bluestats->url->player($value) . "\"><img src=\"https://minotar.net/helm/{$value}/32.png\" alt=\"\"> {$value}</a>";
                                }
                                array_push($values, $value);
                                break;
                            default:
                                array_push($values, $value);
                        }
                        $count++;
                    }
                    call_user_func_array([$table, 'addRecord'], $values);
                }

                // Generate header for table
                $values = [];

                foreach ($plugin->database["stats"][$stat]["values"] as $entry) {
                    switch ($entry["dataType"]) {
                        case "item_id":
                            break;
                        case "item_type":
                            array_push($values, "Block");
                            break;
                        default:
                            array_push($values, $entry["name"]);
                    }
                }
                call_user_func_array([$table, 'makeHeader'], $values);
                $output .= $table->tableToHTML();
            }
        }

        return $output;
    }


}