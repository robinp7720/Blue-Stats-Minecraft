<?php
/** @var module $this */
$this->loadPlugin("Statz");

/** @var \BlueStats\API\plugin $plugin */
$plugin = $this->plugins['Statz'];

$defaultText = array(
    "arrows_shot" => "Shot {VALUE} arrows",
    "blocks_broken" => "Broke {VALUE} blocks",
    "blocks_placed" => "Placed {VALUE} blocks",
    "buckets_emptied" => "Emptied {VALUE} buckets",
    "buckets_filled" => "Filled {VALUE} buckets",
    "commands_performed" => "Executed {VALUE} commands",
    "damage_taken" => "Took {VALUE} damage",
    "deaths" => "Died {VALUE} times",
    "distance_travelled" => "Traveled {VALUE} blocks",
    "eggs_thrown" => "Threw {VALUE} eggs",
    "entered_beds" => "Entered {VALUE} beds",
    "food_eaten" => "Ate {VALUE} foods",
    "items_caught" => "Caught {VALUE} fish",
    "items_crafted" => "Crafted {VALUE} items",
    "items_dropped" => "Dropped {VALUE} items",
    "items_picked_up" => "Picked up {VALUE} items",
    "joins" => "Joined {VALUE} times",
    "kills_mobs" => "Killed {VALUE} mobs",
    "kills_players" => "Killed {VALUE} players",
    "teleports" => "Teleported {VALUE} times",
    "times_kicked" => "Was kicked {VALUE} times",
    "times_shorn" => "Striped {VALUE} sheep",
    "time_played" => "Played for {VALUE}",
    "tools_broken" => "Broke {VALUE} tools",
    "villager_trades" => "Traded {VALUE} times",
    "votes" => "Voted for the server {VALUE} times",
    "words_changed" => "Traveled through {VALUE} realms",
    "xp_gained" => "Gained {VALUE} XP",
);
$this->config->setDefault("english", $defaultText);
$this->config->setDefault("stats", ['votes','teleports','deaths','blocks_broken']);

$english = $this->config->get("english");
$stats = $this->config->get("stats");
?>
<div class="row">
    <?php foreach ($stats as $stat): ?>
        <?php
        $data = $plugin->stats->statList($stat, 1);
        $display = 0;
        $linkId = "";
        if (isset($data[0])) {
            $display = $data[0]["aggregate"];

            if ($plugin->database['identifier'] == "id") {
                $username = $plugin->player->getName($data[0]['id']);
                $uuid = $plugin->player->getUUID($data[0]['id']);
            } else {
                $username = $plugin->player->getName($plugin->player->getID($data[0]['id']));
                $uuid = $data[0]['id'];
            }

            if ($this->bluestats->url->useUUID) {
                $linkId = $uuid;
            } else {
                $linkId = $username;
            }
        }

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
                        class="text-muted"><?= str_replace("{VALUE}", $display, $english[$stat]) ?></h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>