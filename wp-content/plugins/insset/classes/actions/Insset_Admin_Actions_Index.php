<?php
add_action('wp_ajax_inssetdelete', array('Insset_Admin_Actions_Index', 'do_the_job'));
add_action('wp_ajax_nopriv_inssetdelete', array('Insset_Admin_Actions_Index', 'do_the_job'));

add_action('wp_ajax_inssetconfig', array('Insset_Admin_Actions_Index', 'update_config'));
// add_action('wp_ajax_nopriv_inssetconfig', array('Insset_Admin_Actions_Index', 'update_config'));

class Insset_Admin_Actions_Index
{

    public static function do_the_job()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        // print("coucou okok let's go");


        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        $Insset_Crud_Index = new Insset_Crud_Index();
        $res = $Insset_Crud_Index->remove($id);

        print $res;
        // print $id;
        // print $firstname;
        // print serialize($_REQUEST);
        exit;
    }

    public static function update_config()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $Insset_Crud_Index = new Insset_Crud_Index();

        foreach ($_REQUEST as $key => $value)
            if (!in_array($key, ['security', 'action']))
                $Insset_Crud_Index->update($key, $value);

        print "update done";

        exit;
    }
}
