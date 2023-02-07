<?php

add_shortcode('INSSET_TEST', array('Insset_Shortcode_Test', 'display'));

class Insset_Shortcode_Test
{

    static function display()
    {
        return serialize(get_query_var('variabletest'));
    }
}
