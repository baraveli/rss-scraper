<?php

class rss{
    public $link;
    public $data_array;
    public $filtered_data = array();

    function __construct($rss_xml){
        $xml=simplexml_load_string($rss_xml);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        $this->data_array = $array;
        $this->processData();


    }
    
    //not done, need to use regex to get that from the path
    function getCategory($link){
        $parsed_url = parse_url($link);
        $url_path = $parsed_url["path"];

        return $url_path;

    }

    //create an array and  filter  all  data to it
    function filterData(){
         
        $items = $this->data_array["channel"]["item"];

        foreach($items as $item){
            $filtered_item = array(
                "title" => $item["title"],
                "link" => $item["link"],
                "date" => $item["pubDate"],
                "category" => "adding category detection soon",
            );
            
            array_push($this->filtered_data,$filtered_item);
        }

    }

    //this is the function that should be called to process link
    function processData(){
        $this->filterData();
        return $this->filtered_data;


    }



}

?>