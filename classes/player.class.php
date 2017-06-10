<?php

class player {
    public  $exist = FALSE;
    public  $uuid  = "";
    public  $name  = "";
    private $config;
    private $mysqli;
    /** @var \BlueStats\API\plugin $basePlugin */
    private $basePlugin;

    /** @var BlueStats $bluestats */
    private $bluestats;


    public function __Construct ($bluestats, $player) {
        $this->mysqli    = $bluestats->mysqli;
        $this->bluestats = $bluestats;

        $this->config = new config($this->mysqli, "Player");

        $this->basePlugin = $this->bluestats->basePlugin;
        $this->name       = $this->basePlugin->player->getName($player);
        $this->uuid       = $this->basePlugin->player->getUUID($player);

        if (isset($this->uuid) && !isset($this->name))
            $this->name = $player;
        if (!isset($this->uuid) && isset($this->name))
            $this->uuid = $player;

        if (isset($this->uuid) && isset($this->name))
            $this->exist = TRUE;

    }
}