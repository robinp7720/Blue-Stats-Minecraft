<?php

/**
 * Created by PhpStorm.
 * User: ricing
 * Date: 4/22/17
 * Time: 12:08 PM
 */
class pluginStats
{

    public $database; // Loaded from parent plugin class
    private $mysql;   // Loaded from parent plugin class

    /**
     * pluginStats constructor.
     * @param $database array Database layout to identify players in the database
     * @param $mysql mysqli Connection to mysql server for plugin
     */
    public function __construct($database, $mysql)
    {
        $this->database = $database;
        $this->mysql = $mysql;
    }

    /**
     * @param $player int Player ID, Name or UUID, according to player identification method
     * @param $stat string Stat name
     * @return int value of selected player stat
     */
    public function player($player, $stat) {
        $mysqli = $this->mysql;
        $stmt = $mysqli->stmt_init();

        // Select the name from the player identification table using the id column for identification
        switch ($this->database["stats"][$stat]["action"]) {
            case "sum":
                $query = "SELECT sum({$this->database["stats"][$stat]["value"]}) FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} WHERE {$this->database["index"]["columns"][$this->database['identifier']]} = ?";
                break;
            default:
                $query = "SELECT {$this->database["stats"][$stat]["value"]} FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} WHERE {$this->database["index"]["columns"][$this->database['identifier']]} = ?";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $player);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();
            return $output;
        }
        return false;
    }

    public function statList($stat, $limit) {

    }
}