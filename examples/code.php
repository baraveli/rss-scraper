<?php
namespace Baraveli\RssScraper;

require_once '../vendor/autoload.php';


$rp = new \Baraveli\RssScraper\Rss();

echo $rp->getRss();