<?php

class config
{
    public $serverId = 1;
    private $BlueStatsMYQLI;
    private $pluginName;

    /**
     * @param $mysqli
     * @param $plugin
     */
    function __construct($mysqli, $plugin)
    {
        $this->BlueStatsMYQLI = $mysqli;
        $this->pluginName = $plugin;
    }

    /**
     * @param string $option
     * @param string $value
     * @param string $plugin
     */
    public function setDefault($option, $value, $plugin = "this")
    {
        if ($plugin == "this")
            $plugin = $this->pluginName;

        if (!$this->configExist($option, $plugin)) {
            $this->set($option, $value, $plugin);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $option
     * @param string $plugin
     * @return bool
     */
    public function configExist($option, $plugin = "this")
    {
        if ($plugin == "this")
            $plugin = $this->pluginName;
        $mysqli = $this->BlueStatsMYQLI;
        $serverId = $this->serverId;
        $stmt = $mysqli->stmt_init();
        if ($stmt->prepare("SELECT count(*) FROM BlueStats_config WHERE `server_id`=? AND `option`=? AND `plugin`=?")) {

            /* bind parameters for markers */
            $stmt->bind_param("iss", $serverId, $option, $plugin);

            /* execute query */
            $stmt->execute();

            /* bind result variables */
            $stmt->bind_result($count);

            /* fetch value */
            $stmt->fetch();

            /* close statement */
            $stmt->close();
        }
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param string $option
     * @param string $value
     * @param string $plugin
     * @return bool
     */
    public function set($option, $value, $plugin = "this")
    {
        $value = json_encode($value);
        if ($plugin == "this")
            $plugin = $this->pluginName;
        $mysqli = $this->BlueStatsMYQLI;
        $stmt = $mysqli->stmt_init();

        /* Update or Insert new config? */
        if ($this->configExist($option, $plugin))
            $query = "UPDATE BlueStats_config SET `value`=? WHERE `server_id`=? and `plugin`=? AND `option`=?";
        else
            $query = "INSERT INTO BlueStats_config (`server_id`, `option`, `plugin`, `value`) VALUES (?, ?, ?, ?)";

        if ($stmt->prepare($query)) {
            /* bind parameters for markers */
            if ($this->configExist($option))
                $stmt->bind_param("siss", $value, $this->serverId, $plugin, $option);
            else
                $stmt->bind_param("isss", $this->serverId, $option, $plugin, $value);

            /* execute query */
            $stmt->execute();
            /* close statement */
            $stmt->close();
            return true;
        }
        return false;
    }

    /**
     * @param $option
     * @param string $plugin
     * @return bool|mixed
     */
    public function get($option, $plugin = "this")
    {
        if ($plugin == "this")
            $plugin = $this->pluginName;
        $mysqli = $this->BlueStatsMYQLI;
        $stmt = $mysqli->stmt_init();

        $query = "SELECT value FROM BlueStats_config WHERE `server_id`=? and `plugin`=? AND `option`=?";

        if ($stmt->prepare($query)) {

            /* bind parameters for markers */
            $stmt->bind_param("iss", $this->serverId, $plugin, $option);

            /* execute query */
            $stmt->execute();

            /* bind result variables */
            $stmt->bind_result($output);

            /* fetch value */
            $stmt->fetch();

            /* close statement */
            $stmt->close();
            return json_decode($output, true);
        }
        return false;
    }
}