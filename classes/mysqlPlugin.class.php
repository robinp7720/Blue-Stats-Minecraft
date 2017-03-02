<?php

abstract class MySQLplugin extends plugin
{
    public $mysqli;
    public $dbname;
    public $prefix = "";
    public $display_in_playerstats = true;
    public $pluginName = "Unnamed plugin";
    public $firstInstall = false;
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

    public $mcPlugin = true;

    public function __construct($mysqli)
    {
        parent::__construct($mysqli);

        if (
            $this->config->setDefault("MYSQL_host", "localhost") &&
            $this->config->setDefault("MYSQL_username", "minecraft") &&
            $this->config->setDefault("MYSQL_password", "password") &&
            $this->config->setDefault("MYSQL_database", "minecraft") &&
            $this->config->setDefault("MYSQL_prefix", $this->plugin["defaultPrefix"])
        ) {
            $this->firstInstall = true;
        }

        $this->config->setDefault("include_in_player_stats", "true");

        $this->dbname = $this->config->get("MYSQL_database");

        $this->prefix = $this->config->get("MYSQL_prefix");
        try {
            $this->mysqli = new mysqli(
                $this->config->get("MYSQL_host"),
                $this->config->get("MYSQL_username"),
                $this->config->get("MYSQL_password"),
                $this->dbname
            );
        } catch (Exception $e) {
            echo $this->pluginName . " could not connect to mysql database.";
            echo "<br> Error: $e<br><br>";
        }

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

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

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

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();
            return $output;
        }
        return false;
    }

    public function getStat($table, $uuid, $group = TRUE)
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT * FROM {$this->prefix}{$table} WHERE {$this->plugin["idColumn"]}=?";

        if ($group)
            $sql = $sql . " GROUP BY {$this->plugin["idColumn"]}";

        $player_id = $this->getId($uuid);
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $player_id);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

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

                // If there is an error log it
                if ($stmt->error && DEBUG)
                    print($stmt->error);

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
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }
        return false;
    }

    public function getStatSum($stat)
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT sum(*) FROM {$this->prefix}{$stat} WHERE {$this->plugin["idColumn"]} IS NOT NULL";
        if ($stmt->prepare($sql)) {
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }
        return false;
    }

    public function getUsers($start = 0, $limit = 10000, $fetchType = MYSQLI_ASSOC, $search = "")
    {

        $stmt = $this->mysqli->stmt_init();

        $search = "%$search%";

        $sql = "SELECT {$this->plugin["UUIDcolumn"]},{$this->plugin["playerNameColumn"]}
        FROM {$this->prefix}{$this->plugin["indexTable"]}
        WHERE {$this->plugin["UUIDcolumn"]} IS NOT NULL AND {$this->plugin["playerNameColumn"]} like ?
        GROUP BY {$this->plugin["UUIDcolumn"]} LIMIT ?,?";


        if ($stmt->prepare($sql)) {
            $stmt->bind_param('sii', $search, $start, $limit);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all($fetchType);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }
        return false;
    }

    public function getUserCount()
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT count(*) FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} IS NOT NULL";
        if ($stmt->prepare($sql)) {
            $stmt->execute();
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }
        return false;
    }
}
