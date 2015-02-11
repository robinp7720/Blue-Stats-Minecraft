<?php
/* Get Block names from minecraft-ids.grahamedgecombe.com */
$blocks_names = json_decode(file_get_contents("http://minecraft-ids.grahamedgecombe.com/items.json"),true);