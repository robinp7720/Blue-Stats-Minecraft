<?php

class view {
    private $bluestats;
    private $theme    = "";
    private $viewPath = "";
    private $appPath  = "";

    private $player = NULL;

    private $page;

    private $url;

    public function __Construct ($bluestats, $viewPath, $appPath) {
        $this->bluestats = $bluestats;
        $this->theme     = $this->bluestats->theme;

        $this->viewPath = str_replace("{THEME}", $this->theme, $viewPath);
        $this->appPath  = $appPath;

        $this->page = str_replace(['/', '.'], '', $this->bluestats->page);

        // Start url generator
        $this->url = new url($bluestats->mysqli);
    }

    public function render ($type = "GLOBAL") {

        // Get template file to render
        $filePath = $this->viewPath . "templates/{$this->page}.html";

        if ($type == "GLOBAL") {
            $filePath = $this->viewPath . "global.html";
        }

        $this->bluestats->config->setDefault('page-names', [
            'home'       => 'Home',
            'allPlayers' => 'All Players',
            'highscores' => 'Highscores',
            'player'     => 'Player | {{ playername }}',
        ]);

        $template = $this->getTemplate($filePath);

        if ($template === FALSE) {
            return $this->error(404);
        }

        $string = $template["content"];
        $player = $this->player;

        $pageNames = $this->bluestats->config->get('page-names');

        // Set page title
        $title = "Unnamed page";
        if (isset($pageNames[$this->page]))
            $title  = $pageNames[$this->page];
        if (!file_exists($this->viewPath . "templates/{$this->page}.html"))
            $title = "Page not found";

        $string = str_replace('{{ title }}', $title, $string);

        $title  = $this->bluestats->config->get('server-name');
        $string = str_replace('{{ server-name }}', $title, $string);


        if (isset($player)) {
            $string = str_replace('{{ playername }}', $player->name, $string);
            $string = str_replace('{{ playeruuid }}', $player->uuid, $string);
        }
        else {
            // Remove replacement strings if not a player page
            $string = str_replace('{{ playername }}', '', $string);
            $string = str_replace('{{ playeruuid }}', '', $string);
        }

        /* Modules with arguments */
        preg_match_all('/{{ module:([^ ]+):([^ ]+) }}/', $string, $matches);

        foreach ($matches[0] as $key => $replaceStr) {
            $module = new module($this->bluestats, $matches[1][$key]);
            $module->setArgs([$matches[2][$key]]);
            if (isset($player))
                $module->setPlayer($player);
            $string = str_replace($replaceStr, $module->render(), $string);
        }

        /* Modules */
        preg_match_all('/{{ module:([^ ]+) }}/', $string, $matches);

        foreach ($matches[0] as $key => $replaceStr) {
            $module = new module($this->bluestats, $matches[1][$key]);
            if (isset($player))
                $module->setPlayer($player);
            $string = str_replace($replaceStr, $module->render(), $string);
        }

        /* URLS */
        preg_match_all('/{{ url:([^ ]+) }}/', $string, $matches);

        foreach ($matches[0] as $key => $replaceStr) {
            $string = str_replace($replaceStr, $this->url->page($matches[1][$key]), $string);
        }
        $string = str_replace('{{ ajax }}', $this->url->urls['ajax'], $string);


        /* Page Content */
        if (strpos($string, '{{ content }}') !== FALSE)
            $string = str_replace("{{ content }}", $this->render("page"), $string);

        return $string;
    }

    private function getTemplate ($filePath) {
        if (file_exists($filePath)) {
            /* Load template file */
            $content = file_get_contents($filePath);

            if (isset($this->bluestats->request["get"]["id"]) && $this->player == NULL)
                $this->player = new player($this->bluestats, $this->bluestats->request["get"]["id"]);

            if (strpos($content, '{{ dieifnotid }}') !== FALSE) {
                if (!isset($this->bluestats->request["get"]["id"])) {
                    return FALSE;
                }
                else {
                    if (!$this->player->exist) {
                        return FALSE;
                    }
                }
            }

            $content = str_replace('{{ dieifnotid }}', '', $content);

            return [
                "content" => $content,
            ];
        }

        return FALSE;
    }

    public function error ($code) {
        /* TODO: Error pages */

        http_response_code($code);

        if ($code == 404) {
            return $this->getTemplate($this->viewPath . "404.html")["content"];
        }

        // If no valid error code supplied, return a 404 error page
        return $this->getTemplate($this->viewPath . "404.html")["content"];
    }

}
