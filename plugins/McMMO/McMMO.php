<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;


class McMMO extends plugin {

    public static $isMySQLplugin = TRUE;
    public        $name          = 'McMMO';
    public        $database      = [
        "prefix"     => "mcmmo_",
        "identifier" => "id", // Can be id, uuid or name. Used to get stats based on id. name or uuid
        "index"      => [ // Define the table which contains used data
                          "table"   => "users",
                          "columns" => [
                              "uuid" => "uuid",
                              "name" => "user",
                              "id"   => "id",
                          ],
        ],
        "groups"     => [
            "skills" => [
                "display" => TRUE,
                "name" => "Skills",
                "headers" => [
                  "Stat",
                  "Value"
                ],
                "stats"      => [
                    "taming_skill",
                    "mining_skill",
                    "woodcutting_skill",
                    "repair_skill",
                    "unarmed_skill",
                    "herbalism_skill",
                    "excavation_skill",
                    "archery_skill",
                    "swords_skill",
                    "axes_skill",
                    "acrobatics_skill",
                    "fishing_skill",
                    "alchemy_skill",
                ],
            ],
        ],
        "stats"      => [
            "taming_skill"      => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Taming",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "taming", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Taming"    // Human readable name of the stat
                    ],
                ],
            ],
            "mining_skill"      => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Mining",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "mining", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Mining"    // Human readable name of the stat
                    ],
                ],
            ],
            "woodcutting_skill" => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Wood Cutting",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "woodcutting", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Wood Cutting"    // Human readable name of the stat
                    ],
                ],
            ],
            "repair_skill"      => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Repair",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "repair", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Repair"    // Human readable name of the stat
                    ],
                ],
            ],
            "unarmed_skill"     => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Unarmed",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "unarmed", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Anarmed"    // Human readable name of the stat
                    ],
                ],
            ],
            "herbalism_skill"   => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Herbalism",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "herbalism", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Herbalism"    // Human readable name of the stat
                    ],
                ],
            ],
            "excavation_skill"  => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Excavation",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "excavation", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Excavation"    // Human readable name of the stat
                    ],
                ],
            ],
            "archery_skill"     => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Archery",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "archery", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Archery"    // Human readable name of the stat
                    ],
                ],
            ],
            "swords_skill"      => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Swords",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "swords", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Swords"    // Human readable name of the stat
                    ],
                ],
            ],
            "axes_skill"        => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Axes",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "axes", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Axes"    // Human readable name of the stat
                    ],
                ],
            ],
            "acrobatics_skill"  => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Acrobatics",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "acrobatics", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Acrobatics"    // Human readable name of the stat
                    ],
                ],
            ],
            "fishing_skill"     => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Fishing",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "fishing", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Fishing"    // Human readable name of the stat
                    ],
                ],
            ],
            "alchemy_skill"     => [
                "database"        => "skills",
                "user_identifier" => "user_id",
                "name"            => "Alchemy",
                "display" => FALSE,
                "values"          => [
                    [
                        "column"    => "alchemy", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Alchemy"    // Human readable name of the stat
                    ],
                ],
            ],
        ],
    ];
}