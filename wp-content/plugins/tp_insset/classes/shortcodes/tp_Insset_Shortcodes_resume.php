<?php

add_shortcode('recap', array('tp_Insset_Shortcodes_resume', 'display'));

class tp_Insset_Shortcodes_resume
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
        $pays_effectuer = $crud ->result("`voyages`",$wpdb->prefix . TP_INSSET_BASENAME . '_pays_effectuer',"`utilisateur`=".$id);
        $utilisateur = $crud -> result("*",$wpdb->prefix . TP_INSSET_BASENAME . '_utilisateurs',"`id`=".$id);
        $age = $helper->CalculAge($utilisateur[0]['date-naissance']);
        $pays_affichage=null;
        for($i=0;$i<sizeof($pays_effectuer);$i++){
            $pays = $crud -> result("*",$wpdb->prefix . TP_INSSET_BASENAME . '_pays',"`id`=".$pays_effectuer[$i]['voyages']);
            $star = "";
            for($j=0;$j<5;$j++){
                if($j<$pays[0]['note'])
                    $star .= "<i class='etoile_rempli'>&#9733; </i>";
                else
                    $star .= "<i class='etoile_vide'>&#10025; </i>";
            }
            $pays_affichage .= "<div class='paysaffichage'> note = ".$star." pays = ".$pays[0]['pays']." </div><br>";
        }
        return "
        <script src=\"https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js\"></script>
        <script id=\"Script_Modal\" type=\"text/x-handlebars-template\" src=\"".plugins_url(TP_INSSET_PLUGIN_NAME."/Assets/HandleBar/tp_Insset_Modal.hbs")."\"></script>
        <div class='modal' id='Modal'>

                    </div>    
        <form id='form' method='GET'>
                <fieldset>
                    <legend>Resume</legend>
                    
                    

                    <div id='utilisateur'>
                        Firstname = ".$utilisateur[0]['prenom']."<br>
                        Name = ".$utilisateur[0]['nom']."<br>
                        Gender = ".$utilisateur[0]['civilite']."<br>
                        Email = ".$utilisateur[0]['email']."<br>
                        Age = $age
                    </div>

                    <div id='pays'>
                        $pays_affichage
                    </div>
                    
                </fieldset>

                <input type='submit' id='resume_valider' value='Valider'>
            </form>

        ";
    }
}
