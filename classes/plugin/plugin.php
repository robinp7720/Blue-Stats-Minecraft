<?php

abstract class plugin
{

    public $player;

    public $database = [
        "identifier" => "id", // Can be id, uuid or name. Used to get stats based on id. name or uuid
        "index" => [ // Define the table which contains used data
            "table" => "players",
            "columns" => [
                "uuid" => "uuid",
                "name" => "name",
                "id" => "id",
            ]
        ],
        "stats" => [
            "jumps" => [
                "database" => "jumps",
                "column"   => "value"
            ]
        ]
    ];

    public function __construct()
    {
        $this->player = new pluginPlayer($this->database);
    }

    public function install() {

    }

    // STAT RETRIEVAL FUNCTIONS

    /**
     * @param int $playerID ID of a player
     * @param String $stat Stat name to get stat of
     */

    public function getStat($playerID,$stat) {

    }
}