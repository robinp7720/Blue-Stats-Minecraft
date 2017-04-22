<?php

/**
 * Created by PhpStorm.
 * User: ricing
 * Date: 4/22/17
 * Time: 11:52 AM
 */
class pluginPlayer
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
        ]
    ];

    /**
     * pluginPlayer constructor.
     * @param $database array Database layout to identify players in the database
     */
    public function __construct($database)
    {
        $this->database = $database;
    }

    /**
     * This function uses the user id to get the username
     * @param int $id ID of user as defined by plugin
     */
    public function getName($id)
    {

    }

    /**
     * This function uses the user id to get the uuid of a user
     * @param int $id ID of user as defined by plugin
     */
    public function getUUID($id)
    {

    }

    /**
     *
     * @param String $user UUID or username of player
     */

    public function getID($user)
    {
        return $this->getIDfromUUID($user) || $this->getIDfromName($user);
    }

    /**
     * @param String $uuid UUID of player
     */

    public function getIDfromUUID($uuid)
    {

    }

    /**
     * @param String $name Username of player
     */

    public function getIDfromName($name)
    {

    }
}