<?php

// TODO: Improve block id to name conversion
function getBlockNameFromID ($id, $data, $blocks_names) {
    foreach ($blocks_names as $item) {
        if ($item['type'] == $id && $item['meta'] == $data)
            return $item['name'];
    }

    return FALSE;
}