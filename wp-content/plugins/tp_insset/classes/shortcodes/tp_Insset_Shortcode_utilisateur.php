<?php

add_shortcode('Utilisateur', array('tp_Insset_Shortcode_utilisateur', 'display'));

class tp_Insset_Shortcode_utilisateur
{

    static function display($atts)
    {
        return "
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
        
";
    }
}
