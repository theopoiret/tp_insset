<?php

class tp_Insset_Front
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'asset'), 999);

        return;
    }

    public function asset()
    {
        wp_register_script('jQuery', plugins_url(TP_INSSET_PLUGIN_NAME .'/assets/js/jquery.min.js',1, true));
        wp_enqueue_script('jQuery'); 
        wp_register_script('theocss', plugins_url(TP_INSSET_PLUGIN_NAME . '/assets/css/tp_Insset_Front_style.css'));
        wp_enqueue_script('theocss');
        wp_register_script('frontJs', plugins_url(TP_INSSET_PLUGIN_NAME . '/assets/js/tp_Insset_Front.js'), TP_INSSET_VERSION, true);
        wp_enqueue_script('frontJs');
        wp_localize_script(
            'frontJs',
            'inssetfrontscript',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );

        return;
    }


}