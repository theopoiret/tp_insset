<?php

add_shortcode('FORMULAIRE', array('Insset_Shortcode_Formulaire', 'display'));

class Insset_Shortcode_Formulaire
{

    static function display($atts)
    {
        $Insset_Helper_Index = new Insset_Helper_Index();

        if (!$Insset_Helper_Index->isOpen())
            return "<p>Formulaire fermé</p>";

        return "<p>OUla ca marche le shortcode ouais</p>

        <form id='form'>
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
                <label for='adress'>Enter adress:</label>
                <input type='text' id='adress' name='adress'>
            </div>
            </fieldset>

            <button id='btn'>oooo</button>
        </form>
        
";
    }
}
