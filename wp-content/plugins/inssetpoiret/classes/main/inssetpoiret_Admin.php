<?php

class inssetpoiret_Admin {

    public function __construct() {

        add_action('admin_menu', array($this, 'menu'), -1);
        return;

    }
    public function menu() {

        add_menu_page(
            __('inssetpoiret','domain'),
            'insset',
            'administrator',
            'inssetpoiret_settings',
            array($this, 'inssetpoiret_settings'),
            'dashicons-admin-generic',
            1
        );

        add_submenu_page(
            'inssetpoiret_settings',
            __('inssetpoiret'),
            __('inssetpoiret'),
            'administrator',
            'inssetpoiret_settings',
            array($this, 'inssetpoiret_settings')
        );
        add_submenu_page(
            'inssetpoiret_settings',
            __('inssetpoiret2'),
            __('inssetpoiret2'),
            'administrator',
            'inssetpoiret_settings2',
            array($this, 'inssetpoiret_settings2')
        );
        add_action('admin_enqueue_scripts', array($this, 'assets'), 999);
        

    }
    public function assets() {
        wp_enqueue_style('admin-style', plugins_url(INSSETPOIRET_PLUGIN_NAME).'/assets/css/admin.css');

         //Ajouter les scripts necessaires
         wp_register_script('inssetB', plugins_url(INSSETPOIRET_PLUGIN_NAME .'/assets/js/admin.js', INSSETPOIRET_PLUGIN_NAME, true));
         wp_enqueue_script('inssetB');
         
     //Point sécurité
         wp_localize_script('inssetB', 'inssetscript', array(
             'ajax_url' => admin_url('admin-ajax.php'), 
             'security' => wp_create_nonce('ajax_nonce_security')
     ));
         return;
    }

    public function inssetpoiret_settings() {

        $inssetpoiret_Views_Inscrits = new inssetpoiret_Views_Inscrits();
        return $inssetpoiret_Views_Inscrits->display();

    }
    public function inssetpoiret_settings2() {

        // $inssetpoiret_Views_Config = new inssetpoiret_Views_Config();
        // return $inssetpoiret_Views_Config->display();
        print"salut";
    }
}
