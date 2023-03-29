<?php

class tp_Insset_Admin
{

    public function __construct()
    {

        add_action('admin_menu', array($this, 'menu'), -1);
        return;
    }

    public function menu()
    {

        add_menu_page(
            'PROJET',
            'PROJET',
            'administrator',
            'projet_settings',
            1000
        );

        add_submenu_page(
            'projet_settings',
            __('Panneau de configuration'),
            __('Panneau de configuration'),
            'administrator',
            'insset_panneau',
            array($this, 'insset_panneau')
        );

        add_submenu_page(
            'projet_settings',
            __('Liste des pays'),
            __('Liste des pays'),
            'administrator',
            'insset_list',
            array($this, 'insset_list')
        );

        add_submenu_page(
            'projet_settings',
            __('Prospect'),
            __('Prospect'),
            'administrator',
            'insset_Prospect',
            array($this, 'insset_Prospect')
        );

        add_action('admin_enqueue_scripts', array($this, 'assets'), 999);
    }


    public function assets()
    {
        wp_enqueue_style('admin-style-new', plugins_url(TP_INSSET_PLUGIN_NAME)  . '/assets/css/Insset_Admin_style.css');

        wp_register_script('adminJs', plugins_url(TP_INSSET_PLUGIN_NAME . '/assets/js/tp_Insset_Admin.js'), TP_INSSET_VERSION, true);
        wp_enqueue_script('adminJs');
        wp_localize_script(
            'adminJs',
            'inssetadminscript',
            array(
                'ajax_url' => admin_url('admin_ajax.php'),
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );
        return;
    }

    public function insset_panneau()
    {
        $panneau = new tp_Insset_View_Panneau();
        return $panneau->display();
    }

    public function insset_list()
    {
        $list = new tp_Insset_View_List();
        return $list->display();
    }

    public function insset_Prospect()
    {
        $prosect = new tp_Insset_View_Prospect();
        return $prosect->display();
    }
}
