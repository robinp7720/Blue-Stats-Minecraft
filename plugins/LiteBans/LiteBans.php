<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;


class LiteBans extends plugin {

    public static $isMySQLplugin = TRUE;
    public        $name          = 'LiteBans';
    public        $database      = [
        "prefix"     => "litebans_",
        "identifier" => "uuid",
        "index"      => [
            "table"   => "servers",
            "columns" => [
                "uuid" => "uuid",
                "name" => "user",
            ],
        ],
        "stats"      => [
            "bans" => [
                "database"        => "bans",
                "user_identifier" => "uuid",
                "name"            => "Bans",
                "summary"         => "count",
                "values"          => [
                    [
                        "column"    => "reason",
                        "dataType"  => "string",
                        "aggregate" => TRUE,
                        "name"      => "Reason",
                    ],
                    [
                        "column"    => "ip",
                        "dataType"  => "string",
                        "aggregate" => FALSE,
                        "name"      => "IP",
                    ],
                    [
                        "column"    => "banned_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Banned by",
                    ],
                    [
                        "column"    => "removed_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Removed by",
                    ],
                    [
                        "column"    => "removed_by_date",
                        "dataType"  => "date",
                        "aggregate" => FALSE,
                        "name"      => "Unbanned on",
                    ],
                    [
                        "column"    => "time",
                        "dataType"  => "time",
                        "aggregate" => FALSE,
                        "name"      => "Length",
                    ],
                ],
            ],
            "mutes" => [
                "database"        => "mutes",
                "user_identifier" => "uuid",
                "name"            => "Mutes",
                "summary"         => "count",
                "values"          => [
                    [
                        "column"    => "reason",
                        "dataType"  => "string",
                        "aggregate" => TRUE,
                        "name"      => "Reason",
                    ],
                    [
                        "column"    => "ip",
                        "dataType"  => "string",
                        "aggregate" => FALSE,
                        "name"      => "IP",
                    ],
                    [
                        "column"    => "banned_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Muted by",
                    ],
                    [
                        "column"    => "removed_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Unmuted by",
                    ],
                    [
                        "column"    => "removed_by_date",
                        "dataType"  => "date",
                        "aggregate" => FALSE,
                        "name"      => "Unmuted on",
                    ],                    [
                        "column"    => "time",
                        "dataType"  => "time",
                        "aggregate" => FALSE,
                        "name"      => "Length",
                    ],
                ],
            ],
            "warnings" => [
                "database"        => "warnings",
                "user_identifier" => "uuid",
                "name"            => "Warnings",
                "summary"         => "count",
                "values"          => [
                    [
                        "column"    => "reason",
                        "dataType"  => "string",
                        "aggregate" => TRUE,
                        "name"      => "Reason",
                    ],
                    [
                        "column"    => "ip",
                        "dataType"  => "string",
                        "aggregate" => FALSE,
                        "name"      => "IP",
                    ],
                    [
                        "column"    => "banned_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Warned by",
                    ],
                    [
                        "column"    => "time",
                        "dataType"  => "time",
                        "aggregate" => FALSE,
                        "name"      => "Length",
                    ],
                ],
            ],
            "kicks" => [
                "database"        => "kicks",
                "user_identifier" => "uuid",
                "name"            => "Kicks",
                "summary"         => "count",
                "values"          => [
                    [
                        "column"    => "reason",
                        "dataType"  => "string",
                        "aggregate" => TRUE,
                        "name"      => "Reason",
                    ],
                    [
                        "column"    => "ip",
                        "dataType"  => "string",
                        "aggregate" => FALSE,
                        "name"      => "IP",
                    ],
                    [
                        "column"    => "banned_by_uuid",
                        "dataType"  => "player_uuid",
                        "aggregate" => FALSE,
                        "name"      => "Kicked by",
                    ],
                ],
            ],
        ],
    ];
}