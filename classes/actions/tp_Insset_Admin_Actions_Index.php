<?php
add_action('wp_ajax_paysactif', array('tp_Insset_Admin_Actions_Index', 'set_pays_actif'));
add_action('wp_ajax_paysnote', array('tp_Insset_Admin_Actions_Index', 'set_pays_note'));
add_action('wp_ajax_paysmajeur', array('tp_Insset_Admin_Actions_Index', 'set_pays_majeur'));

class tp_Insset_Admin_Actions_Index
{

    public static function set_pays_actif()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $taille_tableau = $_REQUEST['taille_tableau'];
        $valeur_selected = explode(",",$_REQUEST['tableau_selected']);
        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();

        for($tab = 0 ; $tab < $taille_tableau; $tab++){
            for($boucle = 0; $boucle < sizeof($valeur_selected) ; $boucle++){
                if($tab == $valeur_selected[$boucle]){
                    $tp_Insset_Crud_Index->update("actif-inactif","0",$wpdb->prefix . TP_INSSET_BASENAME . '_pays',$valeur_selected[$boucle]);
                    $boucle = sizeof($valeur_selected);
                }
                else{
                    $tp_Insset_Crud_Index->update("actif-inactif","1",$wpdb->prefix . TP_INSSET_BASENAME . '_pays',$tab);
                }
            }
        }
        print "Mise à jour faite !";

        exit;
    }

    public static function set_pays_note()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $taille_tableau = $_REQUEST['taille_tableau'];
        $valeur_note = explode(":", $_REQUEST['tableau_note']);
        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();

        $tp_Insset_Crud_Index->update("note",$valeur_note[1],$wpdb->prefix.TP_INSSET_BASENAME."_pays",$valeur_note[0]);

        print "Mise à jour des notes faite !";

    }

    public static function set_pays_majeur()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $valeur_reserver_majeur = $_REQUEST['dispomajeur'];
        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();

        $default_value = $tp_Insset_Crud_Index->result("`reserver-majeur`", $wpdb->prefix.TP_INSSET_BASENAME."_pays", "`id`=".$valeur_reserver_majeur);

        if($default_value[0]['reserver-majeur'] == 0){
            $tp_Insset_Crud_Index->update("reserver-majeur","1",$wpdb->prefix.TP_INSSET_BASENAME."_pays",$valeur_reserver_majeur);
        }
        else{
            $tp_Insset_Crud_Index->update("reserver-majeur","0",$wpdb->prefix.TP_INSSET_BASENAME."_pays",$valeur_reserver_majeur);
        }

        print "Mise à jour faite !";
    }
}
