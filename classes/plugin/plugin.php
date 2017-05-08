<?php

abstract class plugin
{
    public $name = 'A plugin';


    public $stats;
    public $player;

    private $mysql;
    private $config;

    public $database = [
        "prefix" => "statz_",
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

    /**
     * plugin constructor.
     * @param $mysql mysqli MySQL connection for BlueStats config database;
     */
    public function __construct($mysql)
    {
        // Create config object. This is used to retrieve all the config option used throughout the plugin
        $this->config = new config($mysql, $this->name);

        // Connect with database server.
        $this->mysql = new mysqli(
            $this->config->get("MYSQL_host"),
            $this->config->get("MYSQL_username"),
            $this->config->get("MYSQL_password"),
            $this->config->get("MYSQL_database")
        );

        $this->player = new pluginPlayer($this->database, $this->mysql);
        $this->stats = new pluginStats($this->database, $this->mysql);
    }

    public function install() {

    }

}