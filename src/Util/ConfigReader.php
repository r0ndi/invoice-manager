<?php

namespace App\Util;

use Symfony\Component\Yaml\Yaml;

class ConfigReader
{
    private $file;
    private $configContent;

    const DEFAULT_NAME = 'config.yaml';
    const DEFAULT_PATH = __DIR__ . '/../../config/';

    public function __construct(string $path = '', string $name = '')
    {
        if (empty($path) || empty($name)) {
            $path = self::DEFAULT_PATH;
            $name = self::DEFAULT_NAME;
        }

        $this->setFile($path, $name);
        $this->setUpConfigContent();
    }

    public function get(string $fieldName)
    {
        if ($this->has($fieldName)) {
            return $this->configContent[$fieldName];
        }

        return null;
    }

    public function has($fieldName): bool
    {
        return isset($this->configContent[$fieldName]);
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(string $path, string $name): void
    {
        $this->file = new File($path, $name);
    }

    private function setUpConfigContent(): void
    {
        $configContent = $this->getFile()->getContent();
        $configContent = ConfigReader::escapeConfigFile($configContent);
        $configContent = Yaml::parse($configContent);

        $this->configContent = !empty($configContent) ? $configContent : [];
    }

    public static function escapeConfigFile($configFileContent): string
    {
        return str_replace(['%', '\\'], '', addslashes($configFileContent));
    }
}