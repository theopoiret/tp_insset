<?php

class Insset_Helper_Index
{

    // methode qui va lire les configs
    public function isOpen()
    {
        $configs = Insset_Crud_Index::getConfigs();

        foreach ($configs as $config)
            if ($id = $config['id'])
                $$id = $config['value'];

        if (!@$dateOuverture || !@$dateFermeture)
            return false;

        $start_at = strtotime($dateOuverture);
        $end_at = strtotime($dateFermeture);
        $now = strtotime(date('Y-m-d H:i'));

        return ($now >= $start_at) && ($now <= $end_at);
    }
}

        // $start_at = strtotime("2022-10-12"); // 1665532800
        // $end_at = strtotime("2024-10-12"); // 1728691200
        // var_dump($start_at);
        // var_dump($end_at);
        // var_dump($now);

        //wp-list-table striped
        //type datetime-local