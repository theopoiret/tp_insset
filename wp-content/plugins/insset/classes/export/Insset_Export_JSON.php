<?php

//CSV = comma separating value

// il faut loader le framwork wp pour use les objets d'accès a la BDD
//global $wpdb; ne marche pas ici

$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

global $wpdb;

// $sql = 'SELECT * FROM  ' . $wpdb->prefix . INSSET_BASENAME . "_sub_table_newsletter";
$sql = "SELECT A.*, 
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='firstname' LIMIT 1) AS 'firstname', 
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='email' LIMIT 1) AS 'email',
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='username' LIMIT 1) AS 'username',
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='adress' LIMIT 1) AS 'adress'
FROM " . $wpdb->prefix . INSSET_BASENAME . '_newsletter' . " A ";

$inscrits = $wpdb->get_results($sql, 'ARRAY_A');
// $inscris['email']

ob_start(); // change l'entête de la page

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: application/json; charset=utf-8');

print json_encode($inscrits);

$filename = sprintf('Export_insset_inscrits_%s.json', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();


// json pareil que csv mais y'a pas de header
// tout mettre dans un tableau