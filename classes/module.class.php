<?php

/**
 * Created by PhpStorm.
 * User: robin
 * Date: 6/6/17
 * Time: 5:36 PM
 */
class module {
    /** @var BlueStats $bluestats */
    public $bluestats;
    public $plugins = [];
    public $name;
    public $config;
    public $player;
    public $args;

    public function __construct ($bluestats, $name) {
        /** @var BlueStats $bluestats */
        $this->bluestats = $bluestats;
        $this->name      = $name;
        $this->config    = new config($bluestats->mysqli, "MODULE__" . $name);
    }

    public function loadPlugin ($plugin) {
        if (isset($this->bluestats->plugins[$plugin]))
            $this->plugins[$plugin] = $this->bluestats->plugins[$plugin];
    }

    public function render () {
        /* Replace key with module */
        ob_start();
        if (file_exists($this->bluestats->appPath . "/modules/" . $this->name . ".php")) {
            include($this->bluestats->appPath . "/modules/" . $this->name . ".php");
        }
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * @param player $player
     */
    public function setPlayer ($player) {
        $this->player = $player;
    }

    /**
     * @param mixed $args
     */
    public function setArgs ($args) {
        $this->args = $args;
    }

}