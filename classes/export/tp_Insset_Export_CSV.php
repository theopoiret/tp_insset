<?php

$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

function triming(string $val): string
{
    return trim($val);
}

global $wpdb;

$sql = "SELECT * FROM ".$wpdb->prefix . TP_INSSET_BASENAME . '_utilisateurs';

$inscrits = $wpdb->get_results($sql, 'ARRAY_A');

$boucle = 0;
    $listes_pays[] = null;

    foreach($inscrits as $liste_utilisateurs){
        $sql = "SELECT DISTINCT `voyages` FROM ".$wpdb->prefix . TP_INSSET_BASENAME . '_pays_effectuer'." WHERE `utilisateur`=".$liste_utilisateurs['id'];
        $voyages_effectuer = $wpdb->get_results($sql,'ARRAY_A');

        if(sizeof($voyages_effectuer) != 0){
            foreach($voyages_effectuer as $v_e){
                $sql = "SELECT `ISO alpha-3` FROM ".$wpdb->prefix . TP_INSSET_BASENAME . '_pays'." WHERE `id` = ".$v_e['voyages'];
                $voyages = $wpdb->get_results($sql,'ARRAY_A');
                $listes_pays[$liste_utilisateurs['id']] = null;
                foreach($voyages as $v){
                    if($listes_pays[$liste_utilisateurs['id']] == null){
                        $listes_pays[$liste_utilisateurs['id']] = $v['ISO alpha-3'];
                    }
                    else{
                        $listes_pays[$liste_utilisateurs['id']] = $listes_pays[$liste_utilisateurs['id']]." - ".$v['ISO alpha-3'];
                    }
                }
            }
        }
        else{
            $listes_pays[$liste_utilisateurs['id']] = "Aucun Pays n'a été selectionner par cette personne";
        }
    }

ob_start(); 

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: text/csv; charset=UTF-8');


$heads = array(
    'GENRE',
    'NOM',
    'PRENOM',
    'EMAIL',
    'AGE',
    'PAYS'
);

print '"' . implode('"; "', $heads) . "\"\n";

$tp_Insset_Helper = new tp_Insset_Helper();

foreach ($inscrits as $inscrit) :

    $inscrit = array_map('triming', $inscrit);
    $age = $tp_Insset_Helper->CalculAge($inscrit['date-naissance']);
    $fields = array(
        (string) $inscrit['prenom'],
        (string) $inscrit['nom'],
        (string) $inscrit['civilite'],
        (string) $inscrit['email'],
        (string) $age,
        (string) $listes_pays[$inscrit["id"]],
    );

    print '"' . implode('"; "', $fields) . "\"\n";

endforeach;

$filename = sprintf('Export_insset_projet_utilisateur_%s.csv', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();
