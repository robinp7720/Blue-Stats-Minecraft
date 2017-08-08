<?php

/**
 * Created by PhpStorm.
 * User: ricing
 * Date: 4/22/17
 * Time: 12:08 PM
 */

namespace BlueStats\API;

use mysqli;
use player;

class pluginStats {

    public  $database; // Loaded from parent plugin class
    private $mysql;   // Loaded from parent plugin class

    /** @var pluginPlayer $pluginPlayer */
    private $pluginPlayer;

    /**
     * pluginStats constructor.
     *
     * @param $database array Database layout to identify players in the database
     * @param $mysql    mysqli Connection to mysql server for plugin
     */
    public function __construct ($database, $mysql) {
        $this->database = $database;
        $this->mysql    = $mysql;
    }

    /**
     * @param $player int|player Player ID, Name or UUID, according to player identification method
     * @param $stat   string Stat name
     *
     * @return array all values relating to stat selected from player
     */
    public function player ($player, $stat, $options = []) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Set default method options
        if (!isset($options['summary'])) $options['summary'] = FALSE;

        // If the player argument is of the player class, get the uuid, name or id depending on identification method
        // set in the database layout scheme
        if (get_class($player) == "player") {
            if ($this->database['identifier'] == 'id')
                $player = $this->pluginPlayer->getID($player->uuid);
            elseif ($this->database['identifier'] == 'uuid')
                $player = $player->uuid;
            elseif ($this->database['identifier'] == 'name')
                $player = $player->name;
        }

        $query = "SELECT ";

        if ($options['summary']) {
            foreach ($this->database["stats"][$stat]["values"] as $info) {
                $query .= "sum(`$info[column]`) as $info[column],";
            }
        } else {
            foreach ($this->database["stats"][$stat]["values"] as $info) {
                $query .= "`$info[column]`,";
            }
        }
        // Remove last comma
        $query = substr($query, 0, -1);

        $query .= " FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} WHERE {$this->database["stats"][$stat]["user_identifier"]} = ?";

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

        return FALSE;
    }

    public function statList ($stat, $limit, $options = []) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $aggregateColumn = "";
        $aggregateID = "";

        foreach ($this->database["stats"][$stat]["values"] as $id => $info) {
            if ($info['aggregate']) {
                $aggregateColumn = $info['column'];
                $aggregateID = $id;
                break;
            }
        }

        // Get aggregate type
        $aggregateType = "sum";
        if (isset($this->database["stats"][$stat]["values"][$aggregateID]["aggregate_type"]))
            $aggregateType = $this->database["stats"][$stat]["values"][$aggregateID]["aggregate_type"];

        $query = "SELECT {$this->database["stats"][$stat]["user_identifier"]} as id, {$aggregateType}($aggregateColumn) as aggregate FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} GROUP BY {$this->database["stats"][$stat]["user_identifier"]} ORDER BY $aggregateType($aggregateColumn) DESC LIMIT ?";

        if ($stmt->prepare($query)) {
            $stmt->bind_param("i", $limit);
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

        return FALSE;
    }

    public function sum($stat) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $aggregateColumn = "";
        $aggregateID = "";

        foreach ($this->database["stats"][$stat]["values"] as $id => $info) {
            if ($info['aggregate']) {
                $aggregateColumn = $info['column'];
                $aggregateID = $id;
                break;
            }
        }

        // Get aggregate type
        $aggregateType = "sum";
        if (isset($this->database["stats"][$stat]["values"][$aggregateID]["aggregate_type"]))
            $aggregateType = $this->database["stats"][$stat]["values"][$aggregateID]["aggregate_type"];

        $query = "SELECT {$aggregateType}($aggregateColumn) as total FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]}";

        if ($stmt->prepare($query)) {
            $stmt->execute();

            $stmt->bind_result($count);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $count;
        }
        if ($stmt->error && DEBUG)
            print($stmt->error);

        return FALSE;
    }

    /**
     * @param pluginPlayer $pluginPlayer
     */
    public function setPluginPlayer ($pluginPlayer) {
        $this->pluginPlayer = $pluginPlayer;
    }
}