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
