<?php

class inssetpoiret_Crud_Index{
    public function __construct(){
        return;
    }

    public function ajout($data){
        global $wpdb;
        $wpdb->insert($wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribers',['id'=>0]);
        $LastId=$wpdb->insert_id;
        foreach($data as $key=>$value)
        {
            if (!in_array($key, ['action','security']))
                $wpdb->insert( $wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribersdata', array( 'index' => 0, 'valeur' =>$value, 'cle'=>$key, 'id'=>$LastId ) );
        }
        return $LastId;
    }

    public function remove($var){
        if(!$var)
            return;
        global $wpdb;

        if($wpdb->delete($wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribersdata',['id'=>$var]))
            if($wpdb->delete($wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribers',['id'=>$var]))
                return "suppression effectué";

        return "Erreur !";
    }
}