<?php

class view
{
    private $bluestats;
    private $theme = "";
    private $viewPath = "";
    private $appPath = "";

    private $page;

    private $url;

    public function __Construct($bluestats, $viewPath, $appPath)
    {
        $this->bluestats = $bluestats;
        $this->theme = $this->bluestats->theme;

        $this->viewPath = str_replace("{THEME}", $this->theme, $viewPath);
        $this->appPath = $appPath;

        $this->page = str_replace(array('/', '.'), '', $this->bluestats->page);

        $this->url = new url($bluestats->mysqli);
    }

    private function getTemplate($filePath){
        $continue = true;
        $player = null;
        if (file_exists($filePath)) {
            /* Load template file */
            $string = file_get_contents($filePath);

            if (strpos($string, '{{ dieifnotid }}') !== false) {
                if (!isset($this->bluestats->request["get"]["id"])) {
                    $continue = false;
                } else {
                    $player = new player($this->bluestats, $this->bluestats->request["get"]["id"]);
                    if (!$player->exist) {
                        $continue = false;
                    }
                }
            }

            $string = str_replace('{{ dieifnotid }}', '', $string);
        } else {
            $continue = false;
        }
        return $continue ? ["content"=>$string,"player"=>$player]:false;
    }

    public function render($type = "GLOBAL")
    {

        if ($type == "GLOBAL") {
            $filePath = $this->viewPath . "global.html";
        } else {
            $filePath = $this->viewPath . "templates/{$this->page}.html";
        }

        $template = $this->getTemplate($filePath);
        $string = $template["content"];
        $player = $template["player"];


        if ($string) {

            if (isset($player)) {
                $string = str_replace('{{ playername }}', $player->name, $string);
                $string = str_replace('{{ playeruuid }}', $player->uuid, $string);
                if (strpos($string, '{{ playerstats }}') !== false) {
                    $string = str_replace('{{ playerstats }}', $player->renderPlayerAllStats(), $string);
                }
            }

            /* URLS */
            preg_match_all('/{{ url:([^ ]+) }}/', $string, $matches);

            foreach ($matches[0] as $key => $replaceStr) {
                $string = str_replace($replaceStr, $this->url->page($matches[1][$key]), $string);
            }

            /* Modules with args */
            preg_match_all('/{{ ([^ ]+):([^ ]+):([^ ]+) }}/', $string, $matches);

            foreach ($matches[0] as $key => $replaceStr) {

                /* Plugin Exist? */
                if (isset($this->bluestats->plugins[$matches[1][$key]])) {
                    /* Set plugin */
                    $plugin = $this->bluestats->plugins[$matches[1][$key]];

                    /* New module */
                    $module = new module($this->bluestats->mysqli, $matches[1][$key], $matches[2][$key], $plugin, $this->theme, $this->appPath, $this->url, $matches[3][$key], isset($player) ? $player : NULL);
                    /* Render the module */
                    $output = $module->render();

                    $string = str_replace($replaceStr, $output, $string);
                } else {
                    $output = "Plugin not found: {$matches[1][$key]}";
                    $string = str_replace($replaceStr, $output, $string);
                }
            }

            /* Modules */
            preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

            foreach ($matches[0] as $key => $replaceStr) {

                /* Plugin Exist? */
                if (isset($this->bluestats->plugins[$matches[1][$key]])) {
                    /* Set plugin */
                    $plugin = $this->bluestats->plugins[$matches[1][$key]];

                    /* New module */
                    $module = new module($this->bluestats->mysqli, $matches[1][$key], $matches[2][$key], $plugin, $this->theme, $this->appPath, $this->url, NULL, isset($player) ? $player : NULL);
                    /* Render the module */
                    $output = $module->render();

                    $string = str_replace($replaceStr, $output, $string);
                } else {
                    $output = "Plugin not found: {$matches[1][$key]}";
                    $string = str_replace($replaceStr, $output, $string);
                }
            }

            /* Page Content */
            if (strpos($string, '{{ content }}') !== false)
                $string = str_replace("{{ content }}", $this->render("page"), $string);
        } else {
            $string = $this->error(404);
        }
        return $string;
    }

    public function error($code)
    {
        /* TODO: Error pages */
    }

}