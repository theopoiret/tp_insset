<?php

add_shortcode('pays', array('tp_Insset_Shortcodes_pays', 'display'));

class tp_Insset_Shortcodes_pays
{

    static function display()
    {
        global $wpdb;
        $id = $_GET['id'];
        if($id ==null){
            header('Location: http://localhost/wordpress/utilisateur/');
        }
        $crud = new tp_Insset_Crud_Index();
        $helper = new tp_Insset_Helper();
        $date_naissance = $crud -> result("`date-naissance`",$wpdb->prefix . TP_INSSET_BASENAME . '_utilisateurs',"`id`=".$id);
        $age = $helper->CalculAge($date_naissance[0]['date-naissance']);

        if($age>17)
            $liste_pays = $crud -> result("*",$wpdb->prefix . TP_INSSET_BASENAME . '_pays',"`actif-inactif`=1");
        else
            $liste_pays = $crud -> result("*",$wpdb->prefix . TP_INSSET_BASENAME . '_pays',"`actif-inactif`=1 AND `reserver-majeur`=0");

        $lp=null;
        foreach($liste_pays as $pays){
            $lp.="<option value='".$pays['id']."'>".$pays['pays']."</option>";
        }

        return"
            <form id='form' method='GET'>
                <fieldset>
                    <legend>List country</legend>
                    
                    <div>
                        <select class='slct_pays'>
                            <option value='Rien'>Select your first country</option>
                            $lp
                        </select>
                    </div>

                    <div>
                        <select class='slct_pays' hidden>
                            <option value='Rien'>Select your second country</option>
                            $lp
                        </select>
                    </div>

                    <div>
                        <select class='slct_pays' hidden>
                            <option value='Rien'>Select your third country</option>
                            $lp
                        </select>
                    </div>

                    <div>
                        <select class='slct_pays' hidden>
                            <option value='Rien'>Select your fourth country</option>
                            $lp
                        </select>
                    </div>

                    <div>
                        <select class='slct_pays' hidden>
                            <option value='Rien'>Select your fifth country</option>
                            $lp
                        </select>
                    </div>
                    
                </fieldset>

                <input type='submit' id='pays_valider' value='Valider'>
            </form>
    
        ";
    }
}
