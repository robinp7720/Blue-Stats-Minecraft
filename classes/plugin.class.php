<?php

abstract class plugin
{
    protected $mcPlugin = false;

    protected $config;

    function __construct($mysqli)
    {
        $this->BlueStatsMYQLI = $mysqli;
        $this->config = new config($mysqli, $this->pluginName);
    }
}
