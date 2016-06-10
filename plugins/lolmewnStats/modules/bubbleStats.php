<?php
/*
Html and css for this module was copied from here: http://bootdey.com/snippets/view/Dashboard-user-128 and is released under the MIT licanse
Copyright (c) 2014 bootdey.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
$stats = array(
    "arrows" => "long-arrow-right",
    "beds_entered" => "bed",
    "blocks_broken" => "plus-square-o",
    "blocks_placed" => "minus-square-o",
    "buckets_emptied" => "bitbucket",
    "buckets_filled" => "bitbucket",
    "commands_done" => "terminal",
    "damage_taken" => "heart",
    "death" => "medkit",
    "eggs_thrown" => "asterisk",
    "fish_caught" => "ship",
    "items_crafted" => "plus-circle",
    "items_dropped" => "minus-square-o",
    "items_picked_up" => "plus-square-o",
    "joins" => "sign-in",
    "kill" => "medkit",
    "move" => "bolt",
    "omnomnom" => "cutlery",
    "playtime" => "clock-o",
    "pvp" => "medkit",
    "shears" => "scissors",
    "teleports" => "bolt",
    "times_changed_world" => "bolt",
    "times_kicked" => "user-times",
    "tools_broken" => "unlink",
    "trades" => "exchange",
    "votes" => "thumbs-o-up",
    "xp_gained" => "flask",
    "words_said" => "comment",
);

$config->setDefault("icons", $stats);
$stats = $config->get("icons");

$userCount = $plugin->getUserCount();
?>

<div class="row">
    <div class="col-lg-4 col-sm-6">
        <div class="circle-tile ">
            <a>
                <div class="circle-tile-heading bg-primary">
                    <i class="fa fa-users fa-fw fa-3x"></i>
                </div>
            </a>
            <div class="circle-tile-content bg-primary">
                <div class="circle-tile-description text-faded">User count</div>
                <div class="circle-tile-number text-faded "><?=$userCount?></div>
                <a class="circle-tile-footer" href="<?= $url->page("allPlayers") ?>">All players</a>
            </div>
        </div>
    </div>
    <?php foreach ($stats as $statName => $iconName) : ?>
        <?php $statTitle = $plugin->statName($statName);
        if ($statName!="last_join"&&$statName!="last_seen"){
            $server_total =  (float) $plugin->getAllPlayerStatsSum($statName);
        }else{
            $server_total=0;
        }


        if ($statName!="lastjoin"&&$statName!="lastleave"){
            if ($server_total < 1){
                $server_average = 0;
            }else {
                $server_average = round($server_total / $userCount);
            }
        }else{
            $server_average="";
        }
        if ($statName == "playtime"){
            $server_total=secondsToTime($server_total,false);
            $server_average=secondsToTime($server_average,false);
        }

        ?>
        <div class="col-lg-4 col-sm-6">
            <div class="circle-tile ">
                <a>
                    <div class="circle-tile-heading bg-primary">
                        <i class="fa fa-<?=$iconName?> fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content bg-primary">
                    <div class="circle-tile-description text-faded"> <?=$statTitle?></div>
                    <div class="circle-tile-number text-faded "><?=$server_total?></div>
                    <a class="circle-tile-footer">Server Average: <?=$server_average?></a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
