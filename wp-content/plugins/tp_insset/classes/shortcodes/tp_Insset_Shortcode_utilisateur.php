<?php

add_shortcode('Utilisateur', array('tp_Insset_Shortcode_utilisateur', 'display'));

class tp_Insset_Shortcode_utilisateur
{
    static function display($atts)
    { 
        global $wpdb;
        $tp_Insset_Crud_Index = new tp_Insset_Crud_Index();
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $result_voyages_effectuer = $tp_Insset_Crud_Index->result("*", $wpdb->prefix.TP_INSSET_BASENAME."_pays_effectuer", "`utilisateur`=\"".$id."\"");

            for($boucle = 0 ; $boucle < sizeof($result_voyages_effectuer); $boucle++){
                $result_voyages[$boucle] = $tp_Insset_Crud_Index->result("`pays`,`ISO alpha-3`,`note`", $wpdb->prefix.TP_INSSET_BASENAME."_pays", "`id`=\"".$result_voyages_effectuer[$boucle]['voyages']."\"");
            }

            $boucle = 0;
            foreach($result_voyages as $p){
                $result_all['pays'][$boucle]['ISO alpha-3'] = $p[0]['ISO alpha-3'];
                $boucle++;
            }

            $PaysSelectionner = "['Country'],";
            foreach($result_all['pays'] as $TousPays){
                $PaysSelectionner .= "['".Locale::getDisplayRegion("-".$TousPays['ISO alpha-3'], 'en')."'],";
            }
            $test="<head>
                       
                    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                    <script type='text/javascript'>
                    google.charts.load('current', {
                        'packages':['geochart'],
                    });
                    google.charts.setOnLoadCallback(drawRegionsMap);

                    function drawRegionsMap() {
                        var data = google.visualization.arrayToDataTable([
                        $PaysSelectionner
                        ]);

                        var options = {};

                        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

                        chart.draw(data, options);
                    }
                    </script>

                </head>";
        }
        else{
            $test="";
        }
        return "
        <html>
            ".$test."
            <body>
                <form id='form' method='GET'>
                    <fieldset>
                        <legend>Your coords</legend>
                        
                        <div>
                        <label for='firstname'>Enter firstname:</label>
                        <input type='text' id='firstname' name='firstname'>
                        </div>
                        
                        <div>
                            <label for='username'>Enter name:</label>
                            <input type='text' id='username' name='username'>
                        </div>

                        <div>
                            <label for='email'>Enter email:</label>
                            <input type='text' id='email' name='email'>
                        </div>

                        <div>
                            <label for='genre'>Gender</label>
                            <select id='genre' name='sexe'>
                                <option value='Mr'>Male</option>
                                <option value='Mme'>Female</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for='date'>Enter date of birth:</label>
                            <input type='date' id='date' name='date'>
                        </div>

                    </fieldset>

                    <input type='submit' id='v_utilisateur' value='Valider'>
                </form>
                <div id='regions_div' style='width: 900px; height: 500px;'></div>
            </body>
        </html>     
";
    }
}
