<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

require "minecraftQuery.php";

class query extends plugin
{

        public static $isMySQLplugin = false;
        public $name = 'query';
        public $Query;
        public $info;

        public $onlinePlayers;

        public function __construct ($mysql)
        {
                parent::__construct($mysql);
                $this->config->setDefault("ip", "127.0.0.1");
                $this->config->setDefault("port", "25565");
                $this->Query = new MinecraftQuery();
                try
                {
                        $this->Query->Connect($this->config->get("ip"), $this->config->get("port"));
                        $this->onlinePlayers = $this->Query->GetPlayers();
                        $this->info          = $this->Query->GetInfo();
                }
                catch (MinecraftQueryException $e)
                {
                        // $e->getMessage();
                        // TODO: Display user friendly error when server can't be reached
                }
        }

        public function onlinePlayers ()
        {
                return $this->onlinePlayers ?: [];
        }

}