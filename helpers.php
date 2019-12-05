<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;


class helpers{
    public $config_dir = "./config.json";
    public $config_data ;
    public $data_sources = array();

    function __construct(){
        $this->loadConfig();
        $this->SourcesToArray();
    }

    //loads config from file
    function loadConfig(){
        $file = file_get_contents($this->config_dir, FILE_USE_INCLUDE_PATH);
        $urls = json_decode($file,TRUE);
        //not the best way but error handling
        if ($file == NULL || $urls == NUll  ){
            print("Error reading the config file or it it is empty");
        }
        else{
            $this->config_data = $urls;

        }
    }

    function isValidXml($content){
    $content = trim($content);
    if (empty($content)) {
        return false;
    }
    //html go to hell!
    if (stripos($content, '<!DOCTYPE html>') !== false) {
        return false;
    }

    libxml_use_internal_errors(true);
    simplexml_load_string($content);
    $errors = libxml_get_errors();          
    libxml_clear_errors();  

    return empty($errors);
}
    
    //simple function to get all sources to a defined array so we can loop over it later
    public function SourcesToArray(){
        if ($this->config_data != NULL){
            $this->data_sources = array_keys($this->config_data);

        }
    }
    
    //function to get the data from request needed for error handling purposes
    public function getLink($link){
        $client = new Client([
            'base_uri' => $link,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET');

        $status_code = $response->getStatusCode();
        $body = $response->getBody();
        $isXmlValid = $this->isValidXml($body);
        
        $string_body = (string) $body;

        if ($status_code = 200 && $isXmlValid == true){
            return $string_body;
        }
        else{
            return NULL;
        }


    }

    }


?>