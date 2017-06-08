<?php

class url
{
        public $useUUID = true;
        public $urls = [];
        private $mysqli;
        private $config;
        private $defaultPlayer = "";

        /**
         * @param $mysqli mysqli Connection
         */
        public function __Construct ($mysqli)
        {
                $this->mysqli = $mysqli;
                $this->config = new config($mysqli, "BlueStats-Url");
                $this->setDefault();
                $this->urls          = [
                        "player"  => $this->config->get("player-url"),
                        "default" => $this->config->get("default-url"),
                        "ajax"    => $this->config->get("ajax-base-url"),
                ];
                $this->defaultPlayer = $this->config->get("default-player-page");
                $this->useUUID       = $this->config->get("useUUID") == "true" ? true : false;
        }

        private function setDefault ()
        {
                $this->config->setDefault("player-url", "http://$_SERVER[HTTP_HOST]/{page}/{player}/");
                $this->config->setDefault("default-url", "http://$_SERVER[HTTP_HOST]/{page}/");
                $this->config->setDefault("ajax-base-url", "http://$_SERVER[HTTP_HOST]/ajax/");
                $this->config->setDefault("default-player-page", "player");
                $this->config->setDefault("useUUID", "true");
        }

        public function player ($player)
        {
                return str_replace("{page}", $this->defaultPlayer, str_replace("{player}", $player, $this->urls["player"]));
        }

        public function page ($page)
        {
                return str_replace("{page}", $page, $this->urls["default"]);
        }
}
