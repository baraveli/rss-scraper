
<?php
include 'rss.php';
include 'helpers.php';

$helpers = new helpers();

//rss sources is an array of all the sources
$rss_sources =  $helpers->data_sources;
//print_r($rss_sources);

//this function returns the processed rss given the link
function getRss($link,$helpers){
    $rss_xml = $helpers->getLink($link);
    
    
    if ($rss_xml != NULL){
        $processed_xml = new rss($rss_xml);
        return $processed_xml;
    }
    else{
        return NULL;
    }
}

foreach ($rss_sources as $source){
    $link = $helpers->config_data[$source];
    $data = getRss($link,$helpers);
    print_r($data->filtered_data);
    //print_r($helpers);


} 


?>
