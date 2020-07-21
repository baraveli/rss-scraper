<?php

use Baraveli\RssScraper\Util\Helper;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    use Helper;

    public function testHttpClientReturnsAnArray()
    {
        $client = new \Baraveli\RssScraper\Http\Client();

        $returnValue = $client->get('https://mihaaru.com/rss');

        $this->assertEquals(true, is_array($returnValue));
    }
}
