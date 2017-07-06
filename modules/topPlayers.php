<?php
/** @var module $this */
$this->loadPlugin("Statz");

/** @var \BlueStats\API\plugin $plugin */
$plugin = $this->plugins['Statz'];

$this->config->setDefault("stats", ['votes', 'teleports', 'deaths', 'blocks_broken']);

$language = $this->config->get("language","BlueStats");
$stats   = $this->config->get("stats");
?>

<div class="row">
    <?php foreach ($stats as $stat): ?>
        <?php
        $data    = $plugin->stats->statList($stat, 1);
        $display = 0;
        $linkId  = "";

        if (isset($data[0])) {
            $display = $data[0]["aggregate"];

            if ($plugin->database['identifier'] == "id") {
                $username = $plugin->player->getNamefromID($data[0]['id']);
                $uuid     = $plugin->player->getUUIDfromID($data[0]['id']);
            }
            else {
                $username = $plugin->player->getNamefromID($plugin->player->getID($data[0]['id']));
                $uuid     = $data[0]['id'];
            }

            if ($this->bluestats->url->useUUID) {
                $linkId = $uuid;
            }
            else {
                $linkId = $username;
            }
        }

        $replace = $plugin->database['stats'][$stat]['text'][$language]['plural'];
        if ($display === 1)
            $replace = $plugin->database['stats'][$stat]['text'][$language]['single'];

        ?>
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-default">
                <img src="https://minotar.net/helm/<?= isset($username) ? $username : "char" ?>/300.png"
                     alt="" style="width:100%;">

                <div class="panel-body">
                    <h3 style="margin-top:0;padding:0;"><a
                                href="<?= $this->bluestats->url->player($linkId) ?>"><?= isset($username) ? $username : "Nobody" ?></a>
                    </h3>
                    <h6 style="margin-top:0;padding:0;"
                        class="text-muted"><?= str_replace("{VALUE}", $display, $replace) ?></h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>