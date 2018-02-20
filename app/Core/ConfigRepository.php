<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:42
 */

namespace App\Core;

class ConfigRepository
{
    protected $configs = [];
    protected $configDir;

    const CONFIG_FILE_PATTERN = '/(?P<name>^[\w_]+)\.php$/';

    /**
     * ConfigRepository constructor.
     * @param $configDir
     */
    public function __construct(string $configDir)
    {
        $this->configDir = $configDir;

        $this->scan();
    }

    /**
     * @param string $key
     * @return array
     */
    public function getConfig(string $key): array
    {
        return $this->configs[$key] ?? [];
    }

    protected function scan()
    {
        $files = scandir($this->configDir);

        foreach ($files as $file) {
            if (!$config = $this->isConfigFile($file)) {
                continue;
            }
            $this->setupConfig($config, $file);
        }
    }

    protected function isConfigFile(string $fileName)
    {
        $matches = [];

        if (!preg_match(self::CONFIG_FILE_PATTERN, $fileName, $matches)) {
            return false;
        }

        return $matches['name'];
    }

    protected function setupConfig(string $key, string $file)
    {
        $this->configs[$key] = require "{$this->configDir}/{$file}";
    }
}