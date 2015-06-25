<?php

class mcmmo extends MySQLplugin
{
    public $pluginName = "mcmmo";
    public $plugin = array(
        "idColumn" => "user_id",
        "idColumnInIndex" => "id",
        "playerNameColumn" => "user",
        "UUIDcolumn" => "uuid",
        "indexTable" => "users",
        "UUIDisID" => false,
        "singleTable" => true,
        "valueColumn" => "value",
        "tables" => ["skills", "experience"],
        "defaultPrefix" => "mcmmo_"
    );

    public $stats = [];

    function __construct($mysqli)
    {
        parent::__construct($mysqli);
    }

}