<?php
/** @var module $this */
$this->loadPlugin("query");

if (!isset($this->plugins["query"]))
    return;

$plugin = $this->plugins["query"];

$this->config->setDefault("image-src", "http://cravatar.eu/avatar/{NAME}/64");
$imageSrc = $this->config->get("image-src");
?>
<div class="text-center">
    <?php
    foreach ($plugin->onlinePlayers() as $player):
        $link = $player;
        if ($this->bluestats->url->useUUID)
            $link = $this->bluestats->basePlugin->player->getUUIDfromName($player);
        ?>
        <a href="<?= $this->bluestats->url->player($link) ?>">
            <img src="<?= str_replace("{NAME}", $player, $imageSrc) ?>" alt="<?= $player ?>" title="<?= $player ?>"
                 data-toggle="tooltip" data-placement="top">
        </a>
    <?php endforeach; ?>
</div>