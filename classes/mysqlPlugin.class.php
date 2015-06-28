<?php

class MySQLplugin extends plugin
{
    public $mysqli;
    public $prefix = "";

    public $mcPlugin = true;
    public $display_in_playerstats = true;
    public $pluginName = "Unnamed plugin";
    public $plugin = array(
        "idColumn" => "row_id",
        "playerNameColum" => "name",
        "UUIDcolumn" => "uuid",
        "indexTable" => "players",
        "UUIDisID" => false,
        "singleTable" => true,
        "valueColumn" => "value",
        "tables" => ["skills", "experience"],
        "defaultPrefix" => ""
    );

    public function __construct($mysqli)
    {
        parent::__construct($mysqli);

        $this->config->setDefault("MYSQL_host", "localhost");
        $this->config->setDefault("MYSQL_username", "minecraft");
        $this->config->setDefault("MYSQL_password", "password");
        $this->config->setDefault("MYSQL_database", "minecraft");
        $this->config->setDefault("MYSQL_prefix", $this->plugin["defaultPrefix"]);

        $this->config->setDefault("include_in_player_stats", "true");

        $this->prefix = $this->config->get("MYSQL_prefix");
        $this->mysqli = new mysqli(
            $this->config->get("MYSQL_host"),
            $this->config->get("MYSQL_username"),
            $this->config->get("MYSQL_password"),
            $this->config->get("MYSQL_database")
        );

        $this->display_in_playerstats = $this->config->get("include_in_player_stats");
    }

    public function getUserName($uuid)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->stmt_init();
        $query = "SELECT {$this->plugin["playerNameColumn"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();
            $stmt->close();
            return $output;
        }
        return false;
    }

    public function getUUID($username)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->stmt_init();
        $query = "SELECT {$this->plugin["UUIDcolumn"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["playerNameColumn"]} = ?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();
            $stmt->close();
            return $output;
        }
        return false;
    }

    public function getStat($table, $uuid)
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT * FROM {$this->prefix}{$table} WHERE {$this->plugin["idColumn"]}=? GROUP BY {$this->plugin["idColumn"]}";
        $player_id = $this->getId($uuid);
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $player_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $output = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $output[] = $row;
            }
            $stmt->close();

            return $output;
        }
        return false;
    }

    public function getId($uuid)
    {
        if ($this->plugin["UUIDisID"]) {
            return $uuid;
        } else {
            $mysqli = $this->mysqli;
            $stmt = $mysqli->stmt_init();
            $query = "SELECT {$this->plugin["idColumnInIndex"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} = ?";
            if ($stmt->prepare($query)) {
                $stmt->bind_param("s", $uuid);
                $stmt->execute();
                $stmt->bind_result($id);
                $stmt->fetch();
                $stmt->close();
                return $id;
            }
        }
        return false;
    }

    public function getAllPlayerStats($column)
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT * FROM {$this->prefix}{$column} WHERE {$this->plugin["idColumn"]} IS NOT NULL GROUP BY {$this->plugin["idColumn"]}";
        if ($stmt->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $output = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $output[] = $row;
            }
            $stmt->close();

            return $output;
        }
        return false;
    }

    public function getUsers()
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT * FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} IS NOT NULL GROUP BY {$this->plugin["UUIDcolumn"]}";
        if ($stmt->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $output = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $output[] = $row;
            }
            $stmt->close();

            return $output;
        }
        return false;
    }
}