<?php
/*
Plugin Name: insset
Plugin URI: https://insset.com/
Description: Projet Wordpress
Author: POIRET Théo
Version: 1.0
Author URI: http://insset.com/
*/


if (!defined('ABSPATH'))
    exit;

define('TP_INSSET_VERSION', '1.0.1');
define('TP_INSSET_FILE', __FILE__);
define('TP_INSSET_DIR', dirname(TP_INSSET_FILE));
define('TP_INSSET_BASENAME', pathinfo((TP_INSSET_FILE))['filename']);
define('TP_INSSET_PLUGIN_NAME', TP_INSSET_BASENAME);
if (!defined('TP_INSSET_URL'))
    define('TP_INSSET_URL', 'page_test');

define('TP_INSSET_PAGE_ID', 19);

foreach (glob(TP_INSSET_DIR . '/classes/*/*.php') as $filename)
    if (!preg_match('/export|cron/i', $filename))
        if (!@require_once $filename)
            throw new Exception(sprintf(__('Failed to include %s'), $filename));

register_activation_hook(TP_INSSET_FILE, function () {
    $TP_Insset_Install = new tp_Insset_Install();
    $TP_Insset_Install->setup();
});

if (is_admin())
    new tp_Insset_Admin();
else
    new tp_Insset_Front();
?>
