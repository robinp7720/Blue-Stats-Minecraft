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
        ]
    ];

    public function install() {

    }

    /**
     * @param String | int $id ID of user as defined by plugin
     */
    public function getName($id) {

    }

    /**
     * @param String | int $id ID of user as defined by plugin
     */
    public function getUUID($id) {

    }

    public function getID() {

    }

}