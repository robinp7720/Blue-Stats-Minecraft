<?php

class mcmmo extends legacyMySQLplugin
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
}