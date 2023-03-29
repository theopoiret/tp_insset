<?php

class tp_Insset_View_List
{

    public function display()
    {

        global $wpdb;

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $config = new tp_Insset_Crud_Index();
        $List_pays = $config->result("*",$wpdb->prefix.TP_INSSET_BASENAME."_pays");

?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <hr class="wp-header-end" />
            <div class="notice notice-info notice-alt is-dismissible hide delete-confirmation">
                <p><?php _e('Updated done!'); ?></p>
            </div>
            <?php self::toolbar(); ?>
            <div class="wrap" id="list-table">
                <form id="list-table-form" method="post">
                    <?php
                    $page  = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED);
                    $paged = filter_input(INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT);
                    printf('<input type="hidden" name="page" value="%s" />', $page);
                    printf('<input type="hidden" name="paged" value="%d" />', $paged);
                    ?>
                    <table class="wp-list-table widefat fixed striped table-view-list items">
                        <tr>
                            <td>
                                Pays
                            </td>
                            <td>
                                ISO alpha-3
                            </td>
                            <td>
                                Note de 0 à 5
                            </td>
                            <td>
                                Réserver aux majeurs
                            </td>
                        </tr>
                    <?php
                    foreach($List_pays as $pays){
                        if($pays["actif-inactif"] == 1){
                            printf("<tr id=\"%d\">", $pays['id']);
                                print("<td>".$pays["pays"]."</td>");
                                print("<td>".$pays["ISO alpha-3"]."</td>");
                                print("<td> <select class=\"PaysNote\">");
                                for($i = 0; $i <= 5; $i++){
                                    if($i == $pays["note"]){
                                        printf("<option value=\"%d:%d\" selected> %d </option>",$pays["id"],$i,$i);
                                    }
                                    else{
                                        printf("<option value=\"%d:%d\"> %d </option>",$pays["id"],$i,$i);
                                    }
                                }
                                print("</select> </td>");

                                if($pays["reserver-majeur"] == 1){
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\" checked> </td>",$pays["id"]);
                                }
                                else{
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\"> </td>",$pays["id"]);
                                }
                            print("</tr>");
                        }
                        else{
                            printf("<tr id=\"%d\" style=\"opacity:0.3;\">", $pays['id']);
                                print("<td>".$pays["pays"]."</td>");
                                print("<td>".$pays["ISO alpha-3"]."</td>");
                                print("<td> <select class=\"PaysNote\" disabled>");
                                for($i = 0; $i <= 5; $i++){
                                    if($i == $pays["note"]){
                                        printf("<option value=\"%d:%d\" selected> %d </option>",$pays["id"],$i,$i);
                                    }
                                    else{
                                        printf("<option value=\"%d:%d\"> %d </option>",$pays["id"],$i,$i);
                                    }
                                }
                                print("</select> </td>");

                                if($pays["reserver-majeur"] == 1){
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\" checked disabled> </td>",$pays["id"]);
                                }
                                else{
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\" disabled> </td>",$pays["id"]);
                                }
                            print("</tr>"); 
                        }
                    } 
                    ?>
                </table>
                </form>
            </div>
        </div>
    <?php
    }

    public function toolbar(){
        ?>
        <div>
            <form action="<?php print admin_url('admin-post.php'); ?>" method="post">
                <table>
                    <tbody>
                        <tr>
                            <?php if(defined('TP_INSSET_PLUGIN_NAME')) ?>
                            <td>
                                <a class="button button-secondary" href="<?php print plugins_url(TP_INSSET_PLUGIN_NAME.'/classes/export/tp_Insset_Export_XML.php'); ?>">
                                        <i class="fas fa-save"></i>&nbsp;XML 
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <hr class="wp-header-end">
        <?php
    }
}
