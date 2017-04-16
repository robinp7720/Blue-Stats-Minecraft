<?php

abstract class newPlugin
{

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

    public function install() {

    }

    // PLAYER IDENTIFICATION FUNTIONS

    /**
     * This function uses the user id to get the username 
     * @param int $id ID of user as defined by plugin
     */
    public function getName($id) {

    }

    /**
     * This function uses the user id to get the uuid of a user
     * @param int $id ID of user as defined by plugin
     */
    public function getUUID($id) {

    }

    /**
     *
     * @param String $user UUID or username of player
     */

    public function getID($user) {

    }

    /**
     * @param String $uuid UUID of player
     */

    public function getIDfromUUID($uuid) {

    }

    /**
     * @param String $name Username of player
     */

    public function getIDfromName($name) {

    }

    // STAT RETRIEVAL FUNCTIONS

    /**
     * @param int $playerID ID of a player
     * @param String $stat Stat name to get stat of
     */

    public function getStat($playerID,$stat) {

    }
}