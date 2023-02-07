<?php

class Insset_Front
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'addjs'), 0);

        // ----- ROUTES ----
        add_action('init', array($this, 'declarationDesRoutes'), 0);
        add_filter('query_vars', array($this, 'ajoueCustomVar'));
        add_action('wp_loaded', array($this, 'prendEnCompteAuDessus'));

        return;
    }

    public function addjs()
    {
        wp_register_script('rachid', plugins_url(INSSET_PLUGIN_NAME . '/assets/js/Insset_Front.js'), array('jquery-new'), INSSET_VERSION, true);
        wp_enqueue_script('rachid');
        wp_localize_script(
            'rachid',
            'inssetscript',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );

        return;
    }

    // ----- ROUTES ----

    static function declarationDesRoutes()
    {
        $page = get_post(INSSET_PAGE_ID);

        add_rewrite_rule(
            $page->post_name . '/id/([^/]*)/?$',
            'index.php?pagename=' . $page->post_name . '&variabletest=$matches[1]',
            'top'
        );

        // on peut aussi faire comme ça plus simple ( INSSET_URL = "page_test" )
        // add_rewrite_rule(
        //     INSSET_URL . '/id/([^/]*)/?$',
        //     'index.php?pagename=' . INSSET_URL . '&variabletest=$matches[1]',
        //     'top'
        // );

        return;
    }

    static function ajoueCustomVar($query_vars)
    {
        $query_vars[] = 'variabletest';

        return $query_vars;
    }

    static function prendEnCompteAuDessus()
    {
        global $wp_rewrite;

        return $wp_rewrite->flush_rules();
    }
}
