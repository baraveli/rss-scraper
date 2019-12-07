<?php

use PHPUnit\Framework\TestCase;

use Baraveli\RssScraper\Util\Helper;

class ClientTest extends TestCase
{
    use Helper;

    public function testHttpClientReturnsAnArray()
    {
        $client = new \Baraveli\RssScraper\Http\Client();

        $returnValue = $client->get('http://localhost/rss.xml');

        $this->assertEquals(true, is_array($returnValue));
    }
}
