<?php
add_action('wp_ajax_removeNewsletter', array('inssetpoiret_Admin_Actions', 'do_the_job'));
add_action('wp_ajax_nopriv_removeNewsletter', array('inssetpoiret_Admin_Actions', 'do_the_job'));

class inssetpoiret_Admin_Actions
{

    public static function do_the_job()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        // print("coucou okok let's go");


        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        $Insset_Crud_Index = new inssetpoiret_Crud_Index();
        $res = $Insset_Crud_Index->remove($id);

        print $res;
        // print $id;
        // print $firstname;
        // print serialize($_REQUEST);
        exit;
    }
}