<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;


class McMMO extends plugin
{

        public static $isMySQLplugin = true;
        public $name = 'McMMO';
        public $database = [
                "prefix"     => "mcmmo_",
                "identifier" => "id", // Can be id, uuid or name. Used to get stats based on id. name or uuid
                "index"      => [ // Define the table which contains used data
                        "table"   => "users",
                        "columns" => [
                                "uuid" => "uuid",
                                "name" => "user",
                                "id"   => "id",
                        ]
                ],
                "stats"      => [
                        "Taming"       => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Taming",
                                "values"          => [
                                        [
                                                "column"    => "taming", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Taming"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Mining"       => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Mining",
                                "values"          => [
                                        [
                                                "column"    => "mining", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Mining"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Wood Cutting" => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Wood Cutting",
                                "values"          => [
                                        [
                                                "column"    => "woodcutting", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Wood Cutting"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Repair"       => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Repair",
                                "values"          => [
                                        [
                                                "column"    => "repair", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Repair"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Unarmed"      => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Unarmed",
                                "values"          => [
                                        [
                                                "column"    => "unarmed", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Anarmed"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Herbalism"    => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Herbalism",
                                "values"          => [
                                        [
                                                "column"    => "herbalism", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Herbalism"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Excavation"   => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Excavation",
                                "values"          => [
                                        [
                                                "column"    => "excavation", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Excavation"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Archery"      => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Archery",
                                "values"          => [
                                        [
                                                "column"    => "archery", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Archery"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Swords"       => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Swords",
                                "values"          => [
                                        [
                                                "column"    => "swords", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Swords"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Axes"         => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Axes",
                                "values"          => [
                                        [
                                                "column"    => "axes", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Axes"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Acrobatics"   => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Acrobatics",
                                "values"          => [
                                        [
                                                "column"    => "acrobatics", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Acrobatics"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Fishing"      => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Fishing",
                                "values"          => [
                                        [
                                                "column"    => "fishing", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Fishing"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                        "Alchemy"      => [
                                "database"        => "skills",
                                "user_identifier" => "user_id",
                                "name"            => "Alchemy",
                                "values"          => [
                                        [
                                                "column"    => "alchemy", // column in which the data is stored in the table
                                                "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                                                "aggregate" => true, // If true this column is used as a stat summary
                                                "name"      => "Alchemy"    // Human readable name of the stat
                                        ]
                                ]
                        ],
                ]
        ];
}