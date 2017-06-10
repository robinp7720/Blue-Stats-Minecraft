<?php

/**
 * Created by PhpStorm.
 * User: ricing
 * Date: 4/22/17
 * Time: 11:52 AM
 */

namespace BlueStats\API;

use mysqli;

class pluginPlayer {

    public $database; // Loaded from parent plugin class

    /** @var \mysqli $mysqli */
    private $mysql;   // Loaded from parent plugin class

    /**
     * pluginPlayer constructor.
     *
     * @param $database array Database layout to identify players in the database
     * @param $mysql    mysqli Connection to mysql server for plugin
     */
    public function __construct ($database, $mysql) {
        $this->database = $database;
        $this->mysql    = $mysql;
    }

    /**
     * This function uses the user id to get the username
     *
     * @param int $id ID of user as defined by plugin
     *
     * @return string Username of player
     */
    public function getName ($id) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the name from the player identification table using the id column for identification
        $query = "SELECT {$this->database["index"]["columns"]["name"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["id"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * This function uses the user id to get the uuid of a user
     *
     * @param int $id ID of user as defined by plugin
     *
     * @return string UUID of player
     */
    public function getUUID ($id) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the uuid from the player identification table using the id column for identification
        $query = "SELECT {$this->database["index"]["columns"]["uuid"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["id"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /*
     * @param String $user UUID or username of player
     */

    public function getID ($user) {
        return $this->getIDfromUUID($user) ?: $this->getIDfromName($user);
    }

    /**
     * @param String $uuid UUID of player
     *
     * @return int User id
     */

    public function getIDfromUUID ($uuid) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name Username of player
     *
     * @return int User ID
     */

    public function getIDfromName ($name) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name Username of player
     *
     * @return String User UUID
     */

    public function getUUIDfromName ($name) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["uuid"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name UUID of player
     *
     * @return String User Name
     */

    public function getNamefromUUID ($name) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["name"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $user name or uuid to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */


    public function searchUser ($user, $page = 0, $limit = 100) {
        return $this->searchByName($user, $page, $limit) ?: $this->searchByUUID($user, $page, $limit);
    }

    /**
     * @param String $name name to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */

    public function searchByName ($name, $page = 0, $limit = 100) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $name  = "%$name%";
        $start = $page * $limit;

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} as id, {$this->database["index"]["columns"]["name"]} as name, {$this->database["index"]["columns"]["uuid"]} as uuid FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} LIKE ? LIMIT ?,?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("sii", $name, $start, $limit);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $uuid UUID to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */

    public function searchByUUID ($uuid, $page = 0, $limit = 100) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $uuid  = "%$uuid%";
        $start = $page * $limit;

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} as id, {$this->database["index"]["columns"]["name"]} as name, {$this->database["index"]["columns"]["uuid"]} as uuid FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} LIKE ? LIMIT ?,?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("sii", $uuid, $start, $limit);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }
}