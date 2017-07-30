<?php
/** @var module $this */
$blocks_names = json_decode(file_get_contents($this->bluestats->appPath . "/items.json"), TRUE);

$render = function ($module, $plugin, $blocks_names) {
    $output = "";

    if (!isset($plugin->database['groups'])) $plugin->database['groups'] = [];

    // First render the groups defined in the plugin definition
    foreach ($plugin->database['groups'] as $groupId => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;

        // If group is set to not display, break now to stop rendering
        if (!$info['display']) break;

        $output   .= "<h4>{$plugin->database["groups"][$groupId]["name"]}</h4>";
        $table    = New Table();

        $maxLength = 1;

        foreach ($plugin->database["groups"][$groupId]['stats'] as $stat) {
            $values = [$plugin->database['stats'][$stat]['name']];
            $data = $plugin->stats->player($module->player, $stat);
            foreach ($data[0] as $key => $entry) array_push($values, $entry);
            call_user_func_array([$table, 'addRecord'], $values);
        }

        // Generate header for table
        $values = [];

        foreach ($plugin->database["groups"][$groupId]['headers'] as $entry) {
                array_push($values, $entry);
        }
        call_user_func_array([$table, 'makeHeader'], $values);

        $output .= $table->tableToHTML();
    }


    // Loop through all defined stats in plugin definition
    foreach ($plugin->database['stats'] as $stat => $info) {
        // Set default stat options
        if (!isset($info['display'])) $info['display'] = TRUE;

        if (!$info['display']) break;

        $statName = $plugin->database["stats"][$stat]["name"];
        $table    = New Table();

        // Get stats
        $data = $plugin->stats->player($module->player, $stat);

        // If retrieved stats are empty, don't bother displaying them
        if (!isset($data) || empty($data))
            continue;

        // Add stat title
        $output   .= "<h4>$statName</h4>";

        foreach ($data as $key => $entry) {
            $values = [];
            $count  = 0;
            $itemID = 0;
            foreach ($entry as $statt => $value) {
                switch ($plugin->database["stats"][$stat]["values"][$count]["dataType"]) {
                    case "item_id":
                        // If the data collected was of type item_id, store it and wait until the data type is received.
                        $itemID = $value;
                        break;
                    case "item_type":
                        // If an item type value is recieved assume the item id has already been recieved. Thus, also print the name of the bock into the table
                        $name = getBlockNameFromID($itemID, $value, $blocks_names) ?: getBlockNameFromID($itemID, 0, $blocks_names) ?: $itemID . '-' . $value;
                        array_push($values, $name);
                        break;
                    case "player_name":
                        if ($module->bluestats->url->useUUID) {
                            $uuid  = $module->bluestats->basePlugin->player->getUUIDfromName($value);
                            $value = "<a href=\"" . $module->bluestats->url->player($uuid) . "\"><img src=\"https://minotar.net/helm/{$value}/32.png\" alt=\"\"> {$value}</a>";
                        }
                        else {
                            $value = "<a href=\"" . $module->bluestats->url->player($value) . "\"><img src=\"https://minotar.net/helm/{$value}/32.png\" alt=\"\"> {$value}</a>";
                        }
                        array_push($values, $value);
                        break;
                    case "player_uuid":
                        $uuid  = $value;
                        $name = $module->bluestats->basePlugin->player->getNamefromUUID($value);
                        if ($module->bluestats->url->useUUID) {
                            $value = "<a href=\"" . $module->bluestats->url->player($uuid) . "\"><img src=\"https://minotar.net/helm/{$name}/32.png\" alt=\"\"> {$name}</a>";
                        }
                        else {
                            $value = "<a href=\"" . $module->bluestats->url->player($value) . "\"><img src=\"https://minotar.net/helm/{$name}/32.png\" alt=\"\"> {$name}</a>";
                        }
                        array_push($values, $value);
                        break;
                    case "date":
                        array_push($values, date('H:i m-d-y', $value/1000));
                        break;
                    case "time":
                        array_push($values, secondsToTime($value));
                        break;
                    default:
                        array_push($values, $value);
                }
                $count++;
            }
            call_user_func_array([$table, 'addRecord'], $values);
        }

        // Generate header for table
        $values = [];

        foreach ($plugin->database["stats"][$stat]["values"] as $entry) {
            switch ($entry["dataType"]) {
                case "item_id":
                    break;
                case "item_type":
                    array_push($values, "Block");
                    break;
                default:
                    array_push($values, $entry["name"]);
            }
        }
        call_user_func_array([$table, 'makeHeader'], $values);
        $output .= $table->tableToHTML();
    }

    return $output;
};

if (isset($this->args[0]))
    return print($render($this, $this->bluestats->plugins[$this->args[0]], $blocks_names));

$output = "";

/** @var \BlueStats\API\plugin $plugin */
foreach ($this->bluestats->plugins as $plugin) {
    if ($plugin::$isMySQLplugin)
        $output .= "<h3>$plugin->name</h3>" . $render($this, $plugin, $blocks_names);
}

echo $output;