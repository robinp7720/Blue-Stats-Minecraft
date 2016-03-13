<?php

class cache
{
    private $config;
    private $appPath;
    private $cache_dir;

    public function __construct($mysqli, $appPath)
    {
        $this->appPath = $appPath;

        $this->config = new config($mysqli, "cache");
        $this->config->setDefault("expiry-time", 36000);
        $this->config->setDefault("enabled", "false");
        $this->config->setDefault("cache-directory", $this->appPath . "/cache/");

        $this->cache_dir = $this->config->get("cache-directory");
    }

    public function cache($content, $name)
    {
        if ($this->config->get("enabled") == "true") {
            if (!file_exists($this->cache_dir)) {
                mkdir($this->cache_dir);
            }
            $file_name = md5($name) . '.json';
            $time = time();

            $toSave = array("time" => $time, "content" => $content, "http-code" => http_response_code());

            file_put_contents($this->cache_dir . $file_name, json_encode($toSave));
        }
    }

    public function reCache($name)
    {
        if ($this->config->get("enabled") == "true" && !isset($_GET["recache"])) {
            $file_name = md5($name) . '.json';
            if (file_exists($this->cache_dir . $file_name)) {
                $file = file_get_contents($this->cache_dir . $file_name);
                $cache = json_decode($file, true);
                if ($cache["time"] < time() - $this->config->get("expiry-time")) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function getCache($name)
    {
        $file_name = md5($name) . '.json';
        $currentCache = json_decode(file_get_contents($this->cache_dir . $file_name), true);

        http_response_code($currentCache["http-code"]);

        return $currentCache["content"];
    }
}