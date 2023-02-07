<?php

//CSV = comma separating value

// il faut loader le framwork wp pour use les objets d'accès a la BDD
//global $wpdb; ne marche pas ici

$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

function triming(string $val): string
{
    return trim($val);
}

global $wpdb;

// $sql = 'SELECT * FROM  ' . $wpdb->prefix . INSSET_BASENAME . "_sub_table_newsletter";
$sql = "SELECT A.*, 
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='firstname' LIMIT 1) AS 'firstname', 
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='email' LIMIT 1) AS 'email',
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='username' LIMIT 1) AS 'username',
(SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='adress' LIMIT 1) AS 'adress'
FROM " . $wpdb->prefix . INSSET_BASENAME . '_newsletter' . " A ";

// $inscrits = $wpdb->get_results($sql); une autre methode
// $inscrits->email

$inscrits = $wpdb->get_results($sql, 'ARRAY_A');
// $inscris['email']

ob_start(); // change l'entête de la page

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: text/csv; charset=UTF-8');


$heads = array(
    'ID',
    'FIRSTNAME',
    'USERNAME',
    'EMAIL',
    'ADRESS'
);

print '"' . implode('"; "', $heads) . "\"\n";


foreach ($inscrits as $inscrit) :
    // var_dump($inscrit);

    $inscrit = array_map('triming', $inscrit);

    $fields = array(
        (string) $inscrit['id'],
        (string) $inscrit['firstname'],
        (string) mb_strtoupper($inscrit['username'], 'UTF-8'),
        (string) strtolower($inscrit['email']),
        (string) $inscrit['adress'],
    );

    print '"' . implode('"; "', $fields) . "\"\n";

endforeach;

$filename = sprintf('Export_insset_inscrits_%s.csv', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();
