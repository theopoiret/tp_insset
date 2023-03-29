<?php

class inssetpoiret_Front {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'addjs'), 0);
        return;
    }
    public function addjs() {
            wp_register_script('insset', plugins_url(INSSETPOIRET_PLUGIN_NAME .'/assets/js/inssetpoiret_Front.js'), array('jquery-new'), INSSETPOIRET_VERSION, true);
            wp_enqueue_script('insset');
            wp_localize_script('insset', 'inssetscript', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('ajax_nonce_security'))
            );
            return;
        }
        
}
