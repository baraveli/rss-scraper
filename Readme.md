# Rss scraper

[![Build Status](https://travis-ci.org/baraveli/rss-scraper.svg?branch=master)](https://travis-ci.org/baraveli/rss-scraper)
[![Latest Stable Version](https://poser.pugx.org/baraveli/rss-scraper/v/stable)](https://packagist.org/packages/baraveli/rss-scraper)
[![License](https://poser.pugx.org/baraveli/rss-scraper/license)](https://packagist.org/packages/baraveli/rss-scraper)

![Rss Scraper logo](https://jinas.me/images/baravelirssgithub.jpg)
Rss Scraper to scrap rss feed from news websites.

## :rocket: Installation

```shell
composer require baraveli/rss-scraper
```

## :satellite: Rss Scraper Specs

This documentation decribe the rss scraper structure,usage and how the individual components work in the libary.

## :crystal_ball: General Explanation

The rss scraper get the rss feed of the news from the configuration and get the rss feed items and return the data as a json response or an array.

- ### :hammer: Config loader

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

- ### :flashlight: Http Client

Client class inside the Http directory of the RSS scraper is used to send HTTP request to the RSS feed URL specified in the config to get the content. The class get method gets the content of the RSS URL and check if the returned data is a validxml content. <code>isValidXmL()</code> is helper method that is provided by the helper trait. if the isvalidxml check passes the xml file is then pass to the <code>simplexml_load_string()</code> function that is built into php. the returned loaded string get passed to <code>parseXML</code> method to return the decoded version of the xml file to php array. The data is then returned.

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

    /**
     * get
     *
     * Method to get the rss feed.
     * 
     * This method does parsing of xml to php array and validation checks before returning data.
     * 
     * @param  mixed $link
     *
     * @return void
     */
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

    /**
     * parseXML
     * 
     * This method decode the xml data to php array
     *
     * @param  mixed $xmlfile
     *
     * @return void
     */
    protected function parseXML($xmlfile)
    {
        $json = json_encode($xmlfile);
        $data = json_decode($json, true);

        return $data;
    }
}
```