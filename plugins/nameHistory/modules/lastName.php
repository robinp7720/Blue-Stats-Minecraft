<?php
$names = $plugin->getNames($player->uuid);
if (isset($names[count($names)-2]))
    echo 'Formerly known as ' . $names[count($names)-2]['name'];