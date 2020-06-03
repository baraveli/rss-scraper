<?php
namespace Baraveli\RssScraper;

require_once '../vendor/autoload.php';


$rp = new \Baraveli\RssScraper\Rss();

var_dump($rp->getRss());