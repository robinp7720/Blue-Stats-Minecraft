<?php
namespace BlueStats\Plugin;

class Statz extends \plugin
{

    public $name = 'Statz';

    public $database = [
        "prefix" => "statz_",
        "identifier" => "uuid", // Can be id, uuid or name. Used to get stats based on id. name or uuid
        "index" => [ // Define the table which contains used data
            "table" => "players",
            "columns" => [
                "uuid" => "uuid",
                "name" => "playerName",
                "id" => "id",
            ]
        ],
        "stats" => [
            "joins" => [
                "database" => "joins",
                "value"   => "value",
                "action"   => 'sum'
            ]
        ]
    ];
}