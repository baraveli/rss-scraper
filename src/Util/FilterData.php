<?php

namespace Baraveli\RssScraper\Util;

trait FilterData
{
    public $filtered_data = [];

    /**
     * filter.
     *
     * @param mixed $items
     *
     * This function is responsible for filtering out the rss and getting article item inside the rss feed.
     *
     * @return void
     */
    public function filter($items)
    {
        foreach ($items as $item) {
            $item = $item['channel']['item'];

            array_push($this->filtered_data, $item);
        }

        return $this->filtered_data;
    }
}
