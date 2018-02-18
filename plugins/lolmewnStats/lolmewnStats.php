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
                              "name" => "name",
                              "id"   => "uuid"
                          ],
        ],
        "stats"      => [
            "arrows"     => [
                "database"        => "arrows",
                "name"            => "Arrows shot",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Shot {VALUE} arrow",
                        "plural" => "Shot {VALUE} arrows"
                    ]
                ],
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
                "database"        => "beds_entered",
                "name"            => "Beds entered",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Entered {VALUE} bed",
                        "plural" => "Entered {VALUE} beds"
                    ]
                ],
                "values"          => [
                    [
                        "column"    => "value", // column in which the data is stored in the table
                        "dataType"  => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => TRUE, // If true this column is used as a stat summary
                        "name"      => "Beds entered"    // Human readable name of the stat
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
                "text" => [
                    "en_US" => [
                        "single" => "Broke {VALUE} block",
                        "plural" => "Broke {VALUE} blocks"
                    ]
                ],
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
                    ]
                ],
            ],
            "blocks_placed"   => [
                "database"        => "blocks_placed",
                "name"            => "Blocks placed",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Placed {VALUE} block",
                        "plural" => "Placed {VALUE} blocks"
                    ]
                ],
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
                    ]
                ],
            ],
            "buckets_emptied" => [
                "database"        => "buckets_emptied",
                "name"            => "Buckets emptied",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Emptied {VALUE} bucket",
                        "plural" => "Emptied {VALUE} buckets"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Filled {VALUE} bucket",
                        "plural" => "Filled {VALUE} buckets"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Executed {VALUE} command",
                        "plural" => "Executed {VALUE} commands"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Took {VALUE} damage",
                        "plural" => "Took {VALUE} damage"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Died {VALUE} time",
                        "plural" => "Died {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Threw {VALUE} egg",
                        "plural" => "Threw {VALUE} eggs"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Caught {VALUE} fish",
                        "plural" => "Caught {VALUE} fish"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Crafted {VALUE} item",
                        "plural" => "Crafted {VALUE} items"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Dropped {VALUE} item",
                        "plural" => "Dropped {VALUE} items"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Picked up {VALUE} item",
                        "plural" => "Picked up {VALUE} items"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Joined {VALUE} time",
                        "plural" => "Joined {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "{VALUE} kill",
                        "plural" => "{VALUE} kills"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Last joined on {VALUE}",
                        "plural" => "Last joined on {VALUE}"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Last seen on {VALUE}",
                        "plural" => "Last seen on {VALUE}"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Traveled {VALUE} block",
                        "plural" => "Traveled {VALUE} blocks"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Ate {VALUE} food",
                        "plural" => "Ate {VALUE} foods"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Played for {VALUE}",
                        "plural" => "Played for {VALUE}"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Killed {VALUE} player",
                        "plural" => "Killed {VALUE} players"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Killed {VALUE} players in streaks",
                        "plural" => "Killed {VALUE} players in streaks"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Killed {VALUE} player in their top streak",
                        "plural" => "Killed {VALUE} players in their top streak"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Striped {VALUE} sheep",
                        "plural" => "Striped {VALUE} sheep"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Teleported {VALUE} time",
                        "plural" => "Teleported {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Traveled through {VALUE} realm",
                        "plural" => "Traveled through {VALUE} realms"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Was kicked {VALUE} time",
                        "plural" => "Was kicked {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Broke {VALUE} tool",
                        "plural" => "Broke {VALUE} tools"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Traded {VALUE} time",
                        "plural" => "Traded {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Voted for the server {VALUE} time",
                        "plural" => "Voted for the server {VALUE} times"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Said {VALUE} word",
                        "plural" => "Said {VALUE} words"
                    ]
                ],
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
                "text" => [
                    "en_US" => [
                        "single" => "Gained {VALUE} XP",
                        "plural" => "Gained {VALUE} XP"
                    ]
                ],
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