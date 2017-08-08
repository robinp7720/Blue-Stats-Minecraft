<?php
/** @var module $this */
$this->loadPlugin("query");

if (!isset($this->plugins["query"]))
    return;

$plugin = $this->plugins["query"];

echo count($plugin->onlinePlayers());