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

class pluginStats
{

        public $database; // Loaded from parent plugin class
        private $mysql;   // Loaded from parent plugin class

        /** @var pluginPlayer $pluginPlayer */
        private $pluginPlayer;

        /**
         * pluginStats constructor.
         *
         * @param $database array Database layout to identify players in the database
         * @param $mysql    mysqli Connection to mysql server for plugin
         */
        public function __construct ($database, $mysql)
        {
                $this->database = $database;
                $this->mysql    = $mysql;
        }

        /**
         * @param $player int|player Player ID, Name or UUID, according to player identification method
         * @param $stat   string Stat name
         *
         * @return array all values relating to stat selected from player
         */
        public function player ($player, $stat)
        {
                $mysqli = $this->mysql;
                $stmt   = $mysqli->stmt_init();

                // If the player argument is of the player class, get the uuid, name or id depending on identification method
                // set in the database layout scheme
                if (get_class($player) == "player")
                {
                        if ($this->database['identifier'] == 'id')
                                $player = $this->pluginPlayer->getID($player->uuid);
                        elseif ($this->database['identifier'] == 'uuid')
                                $player = $player->uuid;
                        elseif ($this->database['identifier'] == 'name')
                                $player = $player->name;
                }

                $query = "SELECT ";

                foreach ($this->database["stats"][$stat]["values"] as $info)
                {
                        $query .= "`$info[column]`,";
                }

                // Remove last comma
                $query = substr($query, 0, -1);

                $query .= " FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} WHERE {$this->database["stats"][$stat]["user_identifier"]} = ?";

                if ($stmt->prepare($query))
                {
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

        public function statList ($stat, $limit)
        {
                $mysqli = $this->mysql;
                $stmt   = $mysqli->stmt_init();

                $aggregate = "";

                foreach ($this->database["stats"][$stat]["values"] as $info)
                {
                        if ($info['aggregate'])
                                $aggregate = $info['column'];
                }

                $query = "SELECT {$this->database["stats"][$stat]["user_identifier"]} as id ,sum($aggregate) as aggregate FROM {$this->database["prefix"]}{$this->database["stats"][$stat]["database"]} GROUP BY {$this->database["stats"][$stat]["user_identifier"]} ORDER BY sum($aggregate) DESC LIMIT ?";

                if ($stmt->prepare($query))
                {
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

                return false;
        }

        /**
         * @param pluginPlayer $pluginPlayer
         */
        public function setPluginPlayer ($pluginPlayer)
        {
                $this->pluginPlayer = $pluginPlayer;
        }
}