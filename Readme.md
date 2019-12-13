# Rss scraper

[![Build Status](https://travis-ci.org/baraveli/rss-scraper.svg?branch=master)](https://travis-ci.org/baraveli/rss-scraper)

## Installation

```shell
composer require baraveli/rss-scraper
```

## Rss Scraper Specs

This documentation decribe the rss scraper structure,usage and how the individual components work in the libary.

## General Explanation:

The rss scraper first get the rss feed of the news from the configuration add get the rss feed items and return the data as a json response or an array.

- ### Config loader

Rss scraper configurations are stored in the configs directory as <code>config.json</code> file. The config file has the information about the rss feeds that the rss scraper calls to scrap the rss feed.

Example config:

```json
{
    "mihaaru":"https://mihaaru.com/rss",
    "vaguthu" "https://vaguthu.mv/feed"
}
```

This configuration file is loading the rss feed of [mihaaru](mihaaru.com) and [vaguthu](vaguthu.mv).

Thats pretty much it for the configuration file. Rss scraper has a util <code>ConfigLoader</code> class to load configuration data from the configs directory and return the rss feed url as an array.

The ConfigLoader class has one static load method which takes a <code>filename</code> as an argument to the method as a string. filename will be the name of the json file inside the configs directory. In this case the file name will be config. If a given file is not found load method throws an execption saying "Error reading the config file or it is empty."

Config loader class is shown below:

```php
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
```

- ### Http Client

Client class inside the Http directory of the rss scraper is used to send a http get request to the rss feed url to get the content. The class get method gets the content of the rss url and check if the returned data is a validxml content. <code>isValidXmL()</code> is helper method that is provided by the helper trait. if the isvalidxml check passes the xml file is then pass to the <code>simplexml_load_string()</code> function that is built into php. the returned loaded string get passed to <code>parseXML</code> method to return the decoded version of the xml file to php array. The data is then returned.

This classes uses guzzle to make the http request.

Client class is shown below:

```php
<?php

namespace Baraveli\RssScraper\Http;

use GuzzleHttp\Client as GuzzleClient;
use Baraveli\RssScraper\Util\Helper;

class Client
{
    use Helper;

    private $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function get($link)
    {
        $response = $this->client->request('GET', $link);

        $responseBody = $response->getBody();
        if (!$this->isValidXml($responseBody)) {
            throw new \Exception("The file doesn't contain valid XML");
        }

        $xmlfile = simplexml_load_string($responseBody);
        $data = $this->parseXML($xmlfile);

        return $data;
    }

    protected function parseXML($xmlfile)
    {
        $json = json_encode($xmlfile);
        $data = json_decode($json, true);

        return $data;
    }
}
```