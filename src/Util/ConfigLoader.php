<?php

namespace Baraveli\RssScraper\Util;

use Baraveli\RssScraper\Interfaces\IConfigLoader;

class ConfigLoader implements IConfigLoader
{
    /**
     * load
     *
     * @param  mixed $filename
     *
     * This static method loads configuration files from the configs directory
     * 
     * @return array
     */
    public static function load(string $filename): array
    {
        $path = IConfigLoader::DIRECTORY_PATH . $filename .  '.json';

        $file = file_get_contents($path, FILE_USE_INCLUDE_PATH);
        $urls = json_decode($file, TRUE);

        if (!isset($file, $urls)) {
            throw new \Exception("Error reading the config file or it it is empty");
        }

        return $urls;
    }
}