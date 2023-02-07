<?php

add_shortcode('FORMULAIRE', array('inssetformulaire', 'display'));

class inssetformulaire {

    static function display($atts) {
        return "
            <form id=\"formulaire\" method=\"POST\">
                <fieldset>
                    <legend><?php _e('Your coords') ?></legend>
                    <div>
                        <input type='text' id='firstname' name='firstname' placeholder='Firstname'>
                        <input type='text' id='lastname' name='lastname' placeholder='Lastname'>
                        <input type='text' id='email' name='email' placeholder='email'>
                        <input type='text' id='postal' name='postal' placeholder='code postal'>
                    </div>
                </fieldset>
                <button id='btn'>bouton</button>
            </form>";
    }

}