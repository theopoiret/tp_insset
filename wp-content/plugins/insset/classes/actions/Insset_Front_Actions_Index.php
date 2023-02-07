<?php
add_action('wp_ajax_inssetnewsletter', array('Insset_Front_Actions_Index', 'do_the_job'));
add_action('wp_ajax_nopriv_inssetnewsletter', array('Insset_Front_Actions_Index', 'do_the_job'));

class Insset_Front_Actions_Index
{
    public static function do_the_job()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;


        $Insset_Crud_Index = new Insset_Crud_Index();
        $refId = $Insset_Crud_Index->insertInNewsLetter();

        foreach ($_REQUEST as $key => $value)
            if (!in_array($key, ['security', 'action']))
                $Insset_Crud_Index->insertInSubTableNewsLetter($refId, $key, $value);

        print "ok";
        // print $firstname;
        // print serialize($_REQUEST);
        exit;
    }
}
