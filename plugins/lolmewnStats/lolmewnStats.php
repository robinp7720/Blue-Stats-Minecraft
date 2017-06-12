<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;


class lolmewnStats extends plugin {

    public static $isMySQLplugin = TRUE;
    public        $name          = 'lolmewnStats';
    public        $database      = [
        "prefix"     => "Stats_",
        "identifier" => "uuid", // Can be id, uuid or name. Used to get stats based on id. name or uuid
        "index"      => [ // Define the table which contains used data
                          "table"   => "players",
                          "columns" => [
                              "uuid" => "uuid",
                              "name" => "name"
                          ],
        ],
        "stats"      => [
            "arrows"     => [
                "database"        => "arrows",
                "name"            => "Arrows shot",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Arrows shot"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "beds_entered"     => [
                "database"        => "arrows",
                "name"            => "Arrows shot",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Arrows shot"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "blocks_broken"   => [
                "database"        => "blocks_broken",
                "name"            => "Blocks broken",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Item name",
                    ],
                    [
                        "column"    => "data",
                        "dataType"  => "item_type",
                        "aggregate" => FALSE,
                        "name"      => "Item value",
                    ],
                ],
            ],
            "blocks_placed"   => [
                "database"        => "blocks_placed",
                "name"            => "Blocks placed",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Item name",
                    ],
                    [
                        "column"    => "data",
                        "dataType"  => "item_type",
                        "aggregate" => FALSE,
                        "name"      => "Item value",
                    ],
                ],
            ],
            "buckets_emptied" => [
                "database"        => "buckets_emptied",
                "name"            => "Buckets emptied",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
            "buckets_filled"  => [
                "database"        => "buckets_filled",
                "name"            => "Buckets filled",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
            "commands_done"  => [
                "database"        => "commands_done",
                "name"            => "Commands executed",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
            "damage_taken"    => [
                "database"        => "damage_taken",
                "name"            => "Damage taken",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Damage"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "cause",
                        "dataType"  => "damage_type",
                        "aggregate" => FALSE,
                        "name"      => "Cause",
                    ],
                ],
            ],
            "death"          => [
                "database"        => "death",
                "name"            => "Deaths",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "cause",
                        "dataType"  => "death_type",
                        "aggregate" => FALSE,
                        "name"      => "Cause of death",
                    ],
                ],
            ],
            "eggs_thrown"     => [
                "database"        => "eggs_thrown",
                "name"            => "Eggs thrown",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
            "fish_caught"    => [
                "database"        => "fish_caught",
                "name"            => "Fish caught",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "items_crafted"   => [
                "database"        => "items_crafted",
                "name"            => "Items crafted",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Item",
                    ],
                ],
            ],
            "items_dropped"   => [
                "database"        => "items_dropped",
                "name"            => "Items dropped",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Item",
                    ],
                ],
            ],
            "items_picked_up" => [
                "database"        => "items_picked_up",
                "name"            => "Items picked up",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Item",
                    ],
                ],
            ],
            "joins"           => [
                "database"        => "joins",
                "name"            => "Joins",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                ],
            ],
            "kills"      => [
                "database"        => "kill",
                "name"            => "Kills",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "weapon",
                        "dataType"  => "weapon_type",
                        "aggregate" => FALSE,
                        "name"      => "Weapon",
                    ],
                    [
                        "column"    => "entityType",
                        "dataType"  => "mob_type",
                        "aggregate" => FALSE,
                        "name"      => "Mob",
                    ],
                ],
            ],
            "last_join"   => [
                "database"        => "last_join",
                "name"            => "Last join",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "date", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "aggregate_type" => "max", // TODO: implement aggregate_type. Default should be sum if not specified.
                        "name"      => "Date"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "last_seen"   => [
                "database"        => "last_seen",
                "name"            => "Last seen",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "date", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "aggregate_type" => "max", // TODO: implement aggregate_type. Default should be sum if not specified.
                        "name"      => "Date"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "move"       => [
                "database"        => "move",
                "name"            => "Distance traversed",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Distance"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "type",
                        "dataType"  => "LOLMEWNSTATS_move_type", // TODO: Implement custom data types for plugins
                        "aggregate" => FALSE,
                        "name"      => "Movement type",
                    ],
                ],
            ],
            "omnomnom"      => [
                "database"        => "omnomnom",
                "name"            => "Food eaten",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "playtime"      => [
                "database"        => "playtime",
                "name"            => "Play time",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "time", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "pvp"      => [
                "database"        => "pvp",
                "name"            => "PvP",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "weapon",
                        "dataType"  => "weapon_name",
                        "aggregate" => FALSE,
                        "name"      => "Weapon",
                    ],
                    [
                        "column"    => "victim",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Victim",
                    ],
                    [
                        "column"    => "time",
                        "dataType"  => "date",
                        "aggregate" => FALSE,
                        "name"      => "Time",
                    ],
                ],
            ],
            "pvp_streak"      => [
                "database"        => "pvp_streak",
                "name"            => "PvP streak",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "pvp_top_streak"      => [
                "database"        => "pvp_top_streak",
                "name"            => "Top PvP streak",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "shears"     => [
                "database"        => "shears",
                "name"            => "Sheep stripped",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
            "teleports"       => [
                "database"        => "teleports",
                "name"            => "Teleports",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "times_changed_world"  => [
                "database"        => "times_changed_world",
                "name"            => "Worlds changed",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ]
                ],
            ],
            "times_kicked"    => [
                "database"        => "times_kicked",
                "name"            => "Kicks",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "tools_broken"    => [
                "database"        => "tools_broken",
                "name"            => "Tools broken",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                    [
                        "column"    => "name",
                        "dataType"  => "item_name",
                        "aggregate" => FALSE,
                        "name"      => "Tool",
                    ],
                ],
            ],
            "trades" => [
                "database"        => "trades",
                "name"            => "Villager trades",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "votes"           => [
                "database"        => "votes",
                "name"            => "Votes",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                ],
            ],
            "words_said" => [
                "database"        => "words_said",
                "name"            => "Words said",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ]
                ],
            ],
            "xp_gained"       => [
                "database"        => "xp_gained",
                "name"            => "XP gained",
                "user_identifier" => "uuid",
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "XP"    // Human readable name of the stat
                    ],
                    [
                        "column"    => "world",
                        "dataType"  => "world",
                        "aggregate" => FALSE,
                        "name"      => "World",
                    ],
                ],
            ],
        ],
    ];
}