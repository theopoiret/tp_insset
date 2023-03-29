<?php
add_action('wp_ajax_formuti', array('tp_Insset_Front_Actions_Index', 'inscription'));
add_action('wp_ajax_nopriv_formuti', array('tp_Insset_Front_Actions_Index', 'inscription'));

add_action('wp_ajax_formpays', array('tp_Insset_Front_Actions_Index', 'fonction_pays'));
add_action('wp_ajax_nopriv_formpays', array('tp_Insset_Front_Actions_Index', 'fonction_pays'));

add_action('wp_ajax_formresume', array('tp_Insset_Front_Actions_Index', 'fonction_resume'));
add_action('wp_ajax_nopriv_formresume', array('tp_Insset_Front_Actions_Index', 'fonction_resume'));

class tp_Insset_Front_Actions_Index
{
    public static function inscription()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        if($_REQUEST['error']== "No error"){
            $tab_uti[0]=$_REQUEST['prenom'];
            $tab_uti[1]=$_REQUEST['nom'];
            $tab_uti[2]=$_REQUEST['genre'];
            $tab_uti[3]=$_REQUEST['email'];
            $tab_uti[4]=$_REQUEST['date'];

            $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();
            $tp_Insset_Crud_Index->insert($wpdb->prefix . TP_INSSET_BASENAME . "_utilisateurs", $tab_uti);

            $id_uti = $tp_Insset_Crud_Index->result("`id`", $wpdb->prefix . TP_INSSET_BASENAME . "_utilisateurs",
            "`prenom`=\"".$tab_uti[0]."\" AND
            `nom`=\"".$tab_uti[1]."\" AND
            `civilite`=\"".$tab_uti[2]."\" AND
            `email`=\"".$tab_uti[3]."\" AND
            `date-naissance`=\"".$tab_uti[4]."\""
            );

            print $id_uti[0]['id'];
            exit;
            
        }
        else{
            print $_REQUEST['error'];
            exit;
        }

       
        exit;
    }

    public static function fonction_pays()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();
        if($_REQUEST['Error']== "no error"){
            $ListePays[] = null;
            $ListePays[] = explode(",",$_REQUEST['pays_list']);

            $data[0] = $_REQUEST['Id_User'];

            for($boucle = 0 ; $boucle < 5 ; $boucle++){
                $data[1] = $ListePays[1][$boucle];
                $tp_Insset_Crud_Index->insert($wpdb->prefix . TP_INSSET_BASENAME . "_pays_effectuer",$data);  
            }
            print $_REQUEST['Id_User'];
            exit;
        }
        else{
            print "error";
            exit;
        }
    }


    public static function fonction_resume()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        global $wpdb;
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();

        $result_voyages_effectuer = $tp_Insset_Crud_Index->result("*", $wpdb->prefix . TP_INSSET_BASENAME . "_pays_effectuer", "`utilisateur`=\"".$_REQUEST['Id_User']."\"");

        $result_utilisateur = $tp_Insset_Crud_Index->result("`prenom`,`nom`,`civilite`,`email`", $wpdb->prefix . TP_INSSET_BASENAME ."_utilisateurs", "`id`=\"".$result_voyages_effectuer[0]['utilisateur']."\"");
        
        $result_all['utilisateur']['prenom'] = $result_utilisateur[0]['prenom'];
        $result_all['utilisateur']['nom'] = $result_utilisateur[0]['nom'];
        $result_all['utilisateur']['civilite'] = $result_utilisateur[0]['civilite'];
        $result_all['utilisateur']['email'] = $result_utilisateur[0]['email'];

        print json_encode($result_all);
        exit;
    }
}
