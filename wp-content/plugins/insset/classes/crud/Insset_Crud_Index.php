<?php

class Insset_Crud_Index
{

    public function insertInNewsLetter()
    {
        global $wpdb;
        $table_name_newsletter = $wpdb->prefix . INSSET_BASENAME . '_newsletter';

        $wpdb->insert(
            $table_name_newsletter,
            array('id' => 0)
        );
        $idValue = $wpdb->insert_id;

        return $idValue;
    }

    public function insertInSubTableNewsLetter($refId, $key_of_value, $key_value)
    {
        global $wpdb;
        $table_name_sub_newsletter = $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter';

        $wpdb->insert(
            $table_name_sub_newsletter,
            array(
                'id' => $refId,
                'key_of_values' => $key_of_value,
                'key_values' => $key_value,
            )
        );

        return true;
    }

    public function remove($id)
    {
        if (!$id)
            return;

        global $wpdb;

        $table_name_newsletter = $wpdb->prefix . INSSET_BASENAME . '_newsletter';
        $table_name_sub_newsletter = $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter';

        if ($wpdb->delete($table_name_sub_newsletter, array('id' => $id)))
            if ($wpdb->delete($table_name_newsletter, array('id' => $id)))
                return "suppresion effectué";

        return 'Erreur !';
    }

    static function getConfigs()
    {
        global $wpdb;
        $table_name_config = $wpdb->prefix . INSSET_BASENAME . '_config';

        $sql = "SELECT * FROM $table_name_config";

        return $wpdb->get_results($sql, 'ARRAY_A');
    }

    // public function update($dateOuverture, $dateFermeture, $maximumInscrits)
    // {
    //     global $wpdb;

    //     $table_name_config = $wpdb->prefix . INSSET_BASENAME . '_config';

    //     // if ($wpdb->delete($table_name_sub_newsletter, array('id' => $id)))
    //     //         return "update done";
    //     if (
    //         $wpdb->update($table_name_config, array('value' => $dateOuverture), array('id' => "dateOuverture")) ||
    //         $wpdb->update($table_name_config, array('value' => $dateFermeture), array('id' => "dateFermeture")) ||
    //         $wpdb->update($table_name_config, array('value' => $maximumInscrits), array('id' => "maximumInscrits"))
    //     )
    //         return "update done";
    //     else
    //         return 'Erreur !';
    // }

    public function update($key, $value)
    {
        global $wpdb;

        $table_name_config = $wpdb->prefix . INSSET_BASENAME . '_config';

        if ($wpdb->update($table_name_config, array('value' => $value), array('id' => $key)))
            return "update done";
        else
            return 'Erreur';
    }
}
