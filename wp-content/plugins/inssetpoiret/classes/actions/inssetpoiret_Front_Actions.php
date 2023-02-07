<?php

add_action('wp_ajax_inssetpoiret', array('inssetpoiret_Front_Actions', 'doTheJob'));

class inssetpoiret_Front_Actions {

    public static function doTheJob() {

        check_ajax_referer( "ajax_nonce_security", "security" );

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
        exit;

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        $inssetpoiret_Crud_Index = new inssetpoiret_Crud_Index();
        $LastId = $inssetpoiret_Crud_Index->ajout($_REQUEST);

        print $LastId;
        exit;

    }
}