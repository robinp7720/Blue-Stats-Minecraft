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

    public function render($type = "GLOBAL")
    {

        // Get template file to render
        if ($type == "GLOBAL") {
            $filePath = $this->viewPath . "global.html";
        } else {
            $filePath = $this->viewPath . "templates/{$this->page}.html";
        }

        $template = $this->getTemplate($filePath);

        if ($template === false) {
            return $this->error(404);
        }

        $string = $template["content"];
        $player = $template["player"];


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
        $string = str_replace('{{ ajax }}', $this->url->urls['ajax'], $string);

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
                $output = "<div class=\"alert alert-danger\" role=\"alert\">Plugin not Found: {$matches[1][$key]}</div>";
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
                $module->setBasePlugin($this->bluestats->basePlugin);
                /* Render the module */
                $output = $module->render();

                $string = str_replace($replaceStr, $output, $string);
            } else {
                $output = "<div class=\"alert alert-danger\" role=\"alert\">Plugin not Found: {$matches[1][$key]}</div>";
                $string = str_replace($replaceStr, $output, $string);
            }
        }

        /* Page Content */
        if (strpos($string, '{{ content }}') !== false)
            $string = str_replace("{{ content }}", $this->render("page"), $string);

        return $string;
    }

    private function getTemplate($filePath)
    {
        $player = null;
        if (file_exists($filePath)) {
            /* Load template file */
            $content = file_get_contents($filePath);

            if (strpos($content, '{{ dieifnotid }}') !== false) {
                if (!isset($this->bluestats->request["get"]["id"])) {
                    return false;
                } else {
                    $player = new player($this->bluestats, $this->bluestats->request["get"]["id"]);
                    if (!$player->exist) {
                        return false;
                    }
                }
            }

            $content = str_replace('{{ dieifnotid }}', '', $content);
        } else {
            return false;
        }

        return [
            "content" => $content,
            "player" => $player
        ];
    }

    public function error($code)
    {
        /* TODO: Error pages */

        http_response_code($code);

        if ($code == 404) {
            return $this->getTemplate($this->viewPath . "404.html")["content"];
        }
    }

}
