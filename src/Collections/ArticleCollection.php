<?php

namespace Baraveli\RssScraper\Collections;

use Countable;

class ArticleCollection implements Countable
{
    protected $items = [];

    /**
     * __toString.
     *
     * Jsonify the collection automatically when the trying to output as a string.
     *
     * @return void
     */
    public function __toString()
    {
        return $this->jsonify();
    }

    /**
     * add.
     *
     * @param mixed $value
     *
     * Method to add items to the collection array.
     *
     * @return void
     */
    public function add($value)
    {
        $this->items[] = $value;
    }

    /**
     * get.
     *
     * @param mixed $key
     *
     * Method to get the items from the collection array given a (int)key value
     *
     * @return void
     */
    public function get($key)
    {
        return array_key_exists($key, $this->items) ? $this->items[$key] : null;
    }

    /**
     * jsonify.
     *
     * Method to convert the response to json
     *
     * This method is chainable with the getrss() function.
     *
     * @return void
     */
    public function jsonify()
    {
        return json_encode($this->items);
    }

    /**
     * toArray.
     *
     * Method to return the response as an array
     *
     * This method is chainable with the getrss() function.
     *
     * @return void
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * count.
     *
     * Method to count how many items are in the article collection array
     *
     * @return void
     */
    public function count()
    {
        return count($this->items);
    }
}
