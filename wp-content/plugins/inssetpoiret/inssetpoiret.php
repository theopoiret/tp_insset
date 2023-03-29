<?php
/*
Plugin Name: inssetpoiret
Description: plugin insset poiret
Author: Theo
*/
if (!defined('ABSPATH'))
    exit;

define('INSSETPOIRET_VERSION', '1.0.0');
define('INSSETPOIRET_FILE', __FILE__);
define('INSSETPOIRET_DIR', dirname(INSSETPOIRET_FILE));
define('INSSETPOIRET_BASENAME', pathinfo((INSSETPOIRET_FILE))['filename']);
define('INSSETPOIRET_PLUGIN_NAME', INSSETPOIRET_BASENAME);

foreach (glob(INSSETPOIRET_DIR .'/classes/*/*.php') as $filename)
    if (!preg_match('/export|cron/i', $filename))
        if (!@require_once $filename)
            throw new Exception(sprintf(__('Failed to include %s'), $filename));

register_activation_hook(INSSETPOIRET_FILE, function() {
    $inssetpoiret_Install = new inssetpoiret_Install();
    $inssetpoiret_Install->setup();
});

if (is_admin())
    new inssetpoiret_Admin();
else
    new inssetpoiret_Front();