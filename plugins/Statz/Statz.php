<?php
namespace BlueStats\Plugin;
use BlueStats\API\plugin;


class Statz extends plugin
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
            "arrows_shot" => [
                "database" => "arrows_shot",
                "name" => "Arrows shot",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Arrows shot"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "forceShot",
                        "dataType" => "int",
                        "aggregate" => false,
                        "name" => "Force"
                    ],
                ]
            ],
            "blocks_broken" => [
                "database" => "blocks_broken",
                "name" => "Blocks broken",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "typeid",
                        "dataType" => "item_id",
                        "aggregate" => false,
                        "name" => "Item ID"
                    ],
                    [
                        "column" => "datavalue",
                        "dataType" => "item_type",
                        "aggregate" => false,
                        "name" => "Item value"
                    ],
                ]
            ],
            "blocks_placed" => [
                "database" => "blocks_placed",
                "name" => "Blocks placed",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "typeid",
                        "dataType" => "item_id",
                        "aggregate" => false,
                        "name" => "Item ID"
                    ],
                    [
                        "column" => "datavalue",
                        "dataType" => "item_type",
                        "aggregate" => false,
                        "name" => "Item value"
                    ],
                ]
            ],
            "buckets_emptied" => [
                "database" => "buckets_emptied",
                "name" => "Buckets emptied",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "buckets_filled" => [
                "database" => "buckets_filled",
                "name" => "Buckets filled",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "damage_taken" => [
                "database" => "damage_taken",
                "name" => "Damage taken",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Damage"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "cause",
                        "dataType" => "damage_type",
                        "aggregate" => false,
                        "name" => "Cause"
                    ]
                ]
            ],
            "deaths" => [
                "database" => "deaths",
                "name" => "Deaths",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "eggs_thrown" => [
                "database" => "eggs_thrown",
                "name" => "Eggs thrown",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "entered_beds" => [
                "database" => "entered_beds",
                "name" => "Beds entered",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "food_eaten" => [
                "database" => "food_eaten",
                "name" => "Food eaten",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "foodEaten",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Food"
                    ]
                ]
            ],
            "items_caught" => [
                "database" => "items_caught",
                "name" => "Items caught",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "caught",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item"
                    ]
                ]
            ],
            "items_crafted" => [
                "database" => "items_crafted",
                "name" => "Items crafted",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "item",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item"
                    ]
                ]
            ],
            "items_dropped" => [
                "database" => "items_dropped",
                "name" => "Items dropped",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "item",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item"
                    ]
                ]
            ],
            "items_picked_up" => [
                "database" => "items_picked_up",
                "name" => "Items picked up",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "item",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item"
                    ]
                ]
            ],
            "joins" => [
                "database" => "joins",
                "name" => "Joins",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ]
                ]
            ],
            "kills_mobs" => [
                "database" => "kills_mobs",
                "name" => "Mobs killed",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "mob",
                        "dataType" => "mob_name",
                        "aggregate" => false,
                        "name" => "Mob"
                    ]
                ]
            ],
            "kills_players" => [
                "database" => "kills_players",
                "name" => "Players killed",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "playerKilled",
                        "dataType" => "player_name",
                        "aggregate" => false,
                        "name" => "Player"
                    ]
                ]
            ],
            "teleports" => [
                "database" => "teleports",
                "name" => "Teleports",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "destWorld",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "Destination world"
                    ]
                ]
            ],
            "times_kicked" => [
                "database" => "times_kicked",
                "name" => "Kicks",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "reason",
                        "dataType" => "string",
                        "aggregate" => false,
                        "name" => "Reason"
                    ]
                ]
            ],
            "times_shorn" => [
                "database" => "times_shorn",
                "name" => "Sheep stripped",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "time_played" => [
                "database" => "time_played",
                "name" => "Playtime",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Time"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
            "tools_broken" => [
                "database" => "tools_broken",
                "name" => "Tools broken",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "item",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Tool"
                    ]
                ]
            ],
            "villager_trades" => [
                "database" => "villager_trades",
                "name" => "Villager trades",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "trade",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "item"
                    ]
                ]
            ],
            "votes" => [
                "database" => "kills_players",
                "name" => "Players killed",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ]
                ]
            ],
            "worlds_changed" => [
                "database" => "worlds_changed",
                "name" => "Worlds changed",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ],
                    [
                        "column" => "destWorld",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "Destination world"
                    ]
                ]
            ],
            "xp_gained" => [
                "database" => "xp_gained",
                "name" => "XP gained",
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "XP"    // Human readable name of the stat
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World"
                    ]
                ]
            ],
        ]
    ];
}