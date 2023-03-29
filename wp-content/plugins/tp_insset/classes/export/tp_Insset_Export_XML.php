<?php


$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

global $wpdb;

$sql ="SELECT * FROM ".$wpdb->prefix . TP_INSSET_BASENAME . '_pays';

$inscrits = $wpdb->get_results($sql, 'ARRAY_A');

ob_start(); 
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header("Content-type: text/xml");

$xml = new SimpleXMLElement('<root/>');
foreach ($inscrits as $inscrit) :
    $event = $xml->addChild('pays');

    foreach ($inscrit as $key => $value) :
        if($key != "ISO alpha-3"){
            $event->addChild($key, $value);
        }   
        else{
            $event->addChild("ISO_alpha-3", $value);
        } 
    endforeach;

endforeach;

print $xml->asXML();



$filename = sprintf('Export_insset_projet_pays_%s.xml', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();
