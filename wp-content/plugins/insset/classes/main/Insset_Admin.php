<?php

class Insset_Admin
{

    public function __construct()
    {

        add_action('admin_menu', array($this, 'menu'), -1);
        return;
    }

    public function menu()
    {

        // 1 menu page 
        // 2 sub menu page : config du menu / grid des data
        // insset : config / list

        // function my_plugin_add_menu_page()
        // {
        //     add_menu_page(
        //         'My Plugin Settings',  // Page title
        //         'My Plugin',           // Menu title
        //         'manage_options',      // Capability
        //         'my-plugin-settings',  // Menu slug
        //         'my_plugin_settings_page_callback',  // Callback function
        //         'dashicons-admin-generic',  // Icon URL
        //         60                      // Position
        //     );
        // }
        // add_action('admin_menu', 'my_plugin_add_menu_page');


        // function my_plugin_add_submenu_page() {
        //     add_submenu_page(
        //         'my-plugin-settings',  // Parent slug
        //         'My Plugin Submenu',   // Page title
        //         'Submenu',             // Menu title
        //         'manage_options',      // Capability
        //         'my-plugin-submenu',   // Menu slug
        //         'my_plugin_submenu_page_callback' // Callback function
        //     );
        // }
        // add_action( 'admin_menu', 'my_plugin_add_submenu_page' );

        add_menu_page(
            'Insset',
            'Insset',
            'administrator',
            'insset_settings',
            array($this, 'insset_settings'),
            1000
        );

        add_submenu_page(
            'insset_settings',
            __('Insset / Config'),
            __('Config'),
            'administrator',
            'insset_config',
            array($this, 'insset_config')
        );

        add_submenu_page(
            'insset_settings',
            __('Insset / List'),
            __('List'),
            'administrator',
            'insset_list',
            array($this, 'insset_list')
        );



        add_action('admin_enqueue_scripts', array($this, 'assets'), 999);
    }


    public function assets()
    {
        wp_enqueue_style('admin-style-new', plugins_url(INSSET_PLUGIN_NAME)  . '/assets/css/Insset_Admin_style.css');

        wp_register_script('adminJs', plugins_url(INSSET_PLUGIN_NAME . '/assets/js/Insset_Admin.js'), INSSET_VERSION, true);
        wp_enqueue_script('adminJs');
        wp_localize_script(
            'adminJs',
            'inssetadminscript',
            array(
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );
        return;
    }

    public function insset_settings()
    {
        return;
    }

    public function insset_config()
    {

        $Insset_Views_Config = new Insset_Views_Config();
        return $Insset_Views_Config->display();
    }

    public function insset_list()
    {

        $Insset_Views_Inscrits = new Insset_Views_Inscrits();
        return $Insset_Views_Inscrits->display();
    }
}
