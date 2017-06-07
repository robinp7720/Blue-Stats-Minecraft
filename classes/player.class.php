<?php

class player
{
    public $exist = false;
    public $uuid = "";
    public $name = "";
    private $config;
    private $mysqli;
    /** @var \BlueStats\API\plugin $basePlugin */
    private $basePlugin;

    /** @var BlueStats $bluestats */
    private $bluestats;


    public function __Construct($bluestats, $player)
    {
        $this->mysqli = $bluestats->mysqli;
        $this->bluestats = $bluestats;

        $this->config = new config($this->mysqli, "Player");

        $this->basePlugin = $this->bluestats->basePlugin;
        $this->name = $this->basePlugin->player->getName($this->basePlugin->player->getID($player));
        if (!empty($this->name)) {
            $this->uuid = $player;
            $this->exist = true;
        } else {
            $this->uuid = $this->basePlugin->player->getUUID($this->basePlugin->player->getID($player));
            if (!empty($this->uuid)) {
                $this->name = $player;
                $this->exist = true;
            } else {
                $this->name = NULL;
                $this->uuid = NULL;
                $this->exist = false;
            }
        }
    }
}