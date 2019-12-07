<?php

namespace Baraveli\RssScraper\Models;

use Baraveli\RssScraper\Models\BaseModel;

class ArticleModel extends BaseModel
{
    public $news_service;
    public $news_service_link;
    public $title;
    public $link;
    public $published_date;
    public $guid;
}
