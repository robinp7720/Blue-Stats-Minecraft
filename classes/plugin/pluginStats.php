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

        $query = "SELECT ";

        foreach ($this->database["stats"][$stat]["values"] as $info) {
            $query .= "`$info[column]` as `$info[name]`,";
        }

        // Remove last comma
        $query = substr($query, 0 , -1);

        $query .= " FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} WHERE {$this->database["index"]["columns"][$this->database['identifier']]} = ?";

        var_dump($query);

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $player);
            $stmt->execute();

            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();
            return $output;
        }
        if ($stmt->error && DEBUG)
            print($stmt->error);

        return false;
    }

    public function statList($stat, $limit) {

    }
}