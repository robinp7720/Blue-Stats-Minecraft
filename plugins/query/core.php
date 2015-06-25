<?php

class onlinePlayers extends plugin
{
    public $pluginName = "onlineQuery";
    public $Query;
    public $info;

    public $onlinePlayers;

    public function __construct($mysql)
    {
        parent::__construct($mysql);
        $this->config->setDefault("ip", "127.0.0.1");
        $this->config->setDefault("port", "25565");

        $this->Query = new xPaw\MinecraftQuery();

        try {
            $this->Query->Connect($this->config->get("ip"), $this->config->get("port"));
            $this->onlinePlayers = $this->Query->GetPlayers();
            $this->info = $this->Query->GetInfo();
        } catch (MinecraftQueryException $e) {
            echo $e->getMessage();
        }
    }

    public function onlinePlayers()
    {
        return $this->onlinePlayers ?: [];
    }
}