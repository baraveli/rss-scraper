<?php

namespace Baraveli\RssScraper;

use Baraveli\RssScraper\Http\Client;
use Baraveli\RssScraper\Interfaces\IRss;
use Baraveli\RssScraper\Collections\ArticleCollection;
use Baraveli\RssScraper\Util\{ConfigLoader, FilterData, Helper};

class Rss implements IRss
{
    use FilterData;
    use Helper;

    private $rss_sources = array();
    private $config_data;
    private $client;

    private $collection;


    public function __construct()
    {
        $this->config_data = ConfigLoader::load('config');
        $this->client = new Client();
        $this->collection = new ArticleCollection();
    }

    /**
     * getRss
     *
     * Method to get the rss feeds
     * 
     * @return void
     */
    public function getRss()
    {
        $this->rss_sources = array_keys($this->config_data);

        foreach ($this->rss_sources as $source) {
            $link = $this->config_data[$source];
            $this->data[] = $this->client->get($link);
        }

        $this->collection->add($this->filter($this->data));

        return $this->collection;
    }
}
