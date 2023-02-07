<?php

class Insset_Install
{

    public function __construct()
    {
        return;
    }

    public function setup()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name_newsletter = $wpdb->prefix . INSSET_BASENAME . '_newsletter';

        if ($this->isTableBaseAlreadyCreated($table_name_newsletter))
            return;


        $sql_create_newsletter = "CREATE TABLE IF NOT EXISTS $table_name_newsletter (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            date DATETIME DEFAULT now() NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if (dbDelta($sql_create_newsletter)) {
            $table_name_sub_newsletter = $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter';

            $sql_create_sub_table_newsletter = "CREATE TABLE IF NOT EXISTS $table_name_sub_newsletter (
                id mediumint(9) NOT NULL,
                key_of_values VARCHAR(255) NOT NULL,
                key_values VARCHAR(255) NOT NULL,
                FOREIGN KEY (id) REFERENCES $table_name_newsletter(id)
            ) $charset_collate;";

            dbDelta($sql_create_sub_table_newsletter);


            // if (dbDelta($sql_create_sub_table_newsletter))
            //     return;
        }

        $table_name_config = $wpdb->prefix . INSSET_BASENAME . '_config';
        $sql_create_config = "CREATE TABLE IF NOT EXISTS $table_name_config (
            id VARCHAR(255) NOT NULL,
            value VARCHAR(255) NOT NULL,
            description VARCHAR(255),
            rank INT(11) NOT NULL
        ) $charset_collate;";

        if (dbDelta($sql_create_config)) {
            $wpdb->insert($table_name_config, array('id' => 'dateOuverture', 'value' => '2022-10-12', 'description' => '', 'rank' => 10));
            $wpdb->insert($table_name_config, array('id' => 'dateFermeture', 'value' => '2024-10-12', 'description' => '', 'rank' => 20));
            $wpdb->insert($table_name_config, array('id' => 'maximumInscrits', 'value' => '300', 'description' => '', 'rank' => 30));
            return;
        }

        return;
    }

    public function isTableBaseAlreadyCreated()
    {
        global $wpdb;

        $sql = 'SHOW TABLES LIKE \'%' . $wpdb->prefix . INSSET_BASENAME . "_newsletter" . '%\'';
        $sql_config = 'SHOW TABLES LIKE \'%' . $wpdb->prefix . INSSET_BASENAME . "_config" . '%\'';

        return $wpdb->get_var($sql) && $wpdb->get_var($sql_config);
    }
}
