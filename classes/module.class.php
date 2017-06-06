<?php

/**
 * Created by PhpStorm.
 * User: robin
 * Date: 6/6/17
 * Time: 5:36 PM
 */
class module
{
    private $bluestats;
    private $plugins = [];
    private $name;

    public function __construct($bluestats, $name)
    {
     $this->bluestats = $bluestats;
     $this->name = $name;
    }

    public function loadPlugin($plugin) {
        $this->plugins[$plugin] = $this->bluestats->plugins[$plugin];
    }

    public function render() {
        /* Replace key with module */
        ob_start();
        if (file_exists($this->bluestats->appPath . "/modules/" . $this->name . ".php")) {
            include($this->bluestats->appPath . "/modules/" . $this->name . ".php");
        }
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

}