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
        $this->config->setDefault("enabled", "true");
        $this->config->setDefault("cache-directory", $this->appPath . "/cache/");

        $this->cache_dir = $this->config->get("cache-directory");
    }

    public function cache($content, $name)
    {
        if ($this->config->get("enabled") == "true") {
            $file_name = md5($name) . '.html';
            $time = time();

            $toSave = array("time" => $time, "content" => $content);

            file_put_contents($this->cache_dir . $file_name, json_encode($toSave));
        }
    }

    public function reCache($name)
    {
        if ($this->config->get("enabled") == "true") {
            $file_name = md5($name) . '.html';
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
        $file_name = md5($name) . '.html';
        return json_decode(file_get_contents($this->cache_dir . $file_name), true)["content"];
    }
}