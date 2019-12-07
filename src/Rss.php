<?php

namespace Baraveli\RssScraper;

use Baraveli\RssScraper\Util\ConfigLoader;
use Baraveli\RssScraper\Http\Client;
use Baraveli\RssScraper\Interfaces\IRss;
use Baraveli\RssScraper\RssBaseUtil;
use Baraveli\RssScraper\Util\FilterData;

class Rss extends RssBaseUtil implements IRss
{
    use FilterData;

    private $rss_sources = array();
    private $config_data;
    private $client;

    public $data = array();

    public function __construct()
    {
        $this->config_data = ConfigLoader::load('config');
        $this->client = new Client();
    }

    /**
     * getRss
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

        $articleItems[] = $this->filter($this->data);

        $data = $this->response($articleItems);

        return $data;
    }

    /**
     * response
     *
     * @param  mixed $data
     *
     * @return void
     */
    protected function response($data)
    {
        return $this->sendResponse($data, 'Rss feed scraped successfuly');
    }
}
