<?php
namespace Baraveli\RssScraper;

require_once '../vendor/autoload.php';

use Baraveli\RssScraper\Models\ArticleModel;


$test = new ArticleModel();
$test->news_service = 'Mihaaru';
$test->news_service_link = 'mihaaaru.com';
$test->title = 'test title';
$test->link = 'mihaaaru.com/news/5055';
$test->published_date = '2019';
$test->guid = 852;

dd($test);