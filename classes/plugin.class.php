<?php

class plugin
{
    protected $config;
    public $mcPlugin = false;

    function __construct($mysqli)
    {
        $this->BlueStatsMYQLI = $mysqli;
        $this->config = new config($mysqli, $this->pluginName);
        if (method_exists($this, "onLoad")) {
            $this->onLoad();
        } else {
        }
    }
}

class MySQLplugin extends plugin
{
    public $mysqli;
    public $prefix = "";

    public $mcPlugin = true;
    public $pluginName = "Unnamed plugin";
    public $plugin = array(
        "idColumn" => "row_id",
        "playerNameColum" => "name",
        "UUIDcolumn" => "uuid",
        "indexTable" => "players",
        "UUIDisID" => false,
        "valueColumn" => "value",
        "defaultPrefix" => ""
    );

    public $stats = [];

    public function __construct($mysqli)
    {
        parent::__construct($mysqli);

        $this->config->setDefault("MYSQL_host","localhost");
        $this->config->setDefault("MYSQL_username","minecraft");
        $this->config->setDefault("MYSQL_password","password");
        $this->config->setDefault("MYSQL_database","minecraft");
        $this->config->setDefault("MYSQL_prefix",$this->plugin["defaultPrefix"]);

        $this->prefix = $this->config->get("MYSQL_prefix");
        $this->mysqli = new mysqli(
            $this->config->get("MYSQL_host"),
            $this->config->get("MYSQL_username"),
            $this->config->get("MYSQL_password"),
            $this->config->get("MYSQL_database")
        );
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

    public function getId($uuid)
    {
        if ($this->plugin["UUIDisID"]) {
            $id = $uuid;
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
            }
        }
        return $id;
    }

    public function getStat($column, $uuid)
    {

        $stmt = $this->mysqli->stmt_init();

        $sql = "SELECT * FROM {$this->prefix}{$column} WHERE {$this->plugin["idColumn"]}=? GROUP BY {$this->plugin["idColumn"]}";
        $id = $this->getId($uuid);
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $id);
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
