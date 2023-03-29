<?php

class inssetpoiret_Install {

    public function __construct() {

        add_action( 'admin_init', array( $this, 'setup' ) );
        return;

    }

    public function setup()
    {
        if ($this->isTableBaseAlreadyCreated())
            return;

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');

        $sql_subscribers = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . INSSETPOIRET_BASENAME . '_subscribers' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `date` DATETIME DEFAULT now() NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;

        if(dbDelta($sql_subscribers)){

        $sql_subscribersdata = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . INSSETPOIRET_BASENAME . '_subscribersdata` (
                `index` INT(11) AUTO_INCREMENT NOT NULL,
                `valeur` VARCHAR(255) NOT NULL,
                `cle` VARCHAR(255) NOT NULL,
                `id` INT(11) NOT NULL,
                PRIMARY KEY (`index`),
                FOREIGN KEY (`id`) REFERENCES `'. $wpdb->prefix . INSSETPOIRET_BASENAME . '_subscribers`(id)
            ) ENGINE=InnoDB '. $charset_collate;

        return dbDelta($sql_subscribersdata);

        }


    }

    public function isTableBaseAlreadyCreated() {

        global $wpdb;

        $sql = 'SHOW TABLES LIKE \'%'. $wpdb->prefix . INSSETPOIRET_BASENAME . '_subscribers' .'%\'';
        return $wpdb->get_var($sql);

    }
}
