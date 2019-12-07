<?php

namespace Baraveli\RssScraper\Util;

trait FilterData
{
    public $filtered_data = array();

    /**
     * filter
     *
     * @param  mixed $items
     *
     * @return void
     */
    public function filter($items)
    {
        foreach ($items as $item) {

            $item = $item["channel"]["item"];

            array_push($this->filtered_data, $item);
        }

        return $this->filtered_data;
    }
}
