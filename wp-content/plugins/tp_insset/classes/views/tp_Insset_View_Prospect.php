<?php

class tp_Insset_View_Prospect
{

    public function display()
    {

        global $wpdb;

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $config = new tp_Insset_Crud_Index();
        $List_utilisateur = $config->result("*",$wpdb->prefix.TP_INSSET_BASENAME."_utilisateurs");

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
                                Humain
                            </td>
                            <td>
                                Nombre de Pays selectionner
                            </td>
                        </tr>
                        <?php 
                            foreach($List_utilisateur as $prospects){
                                print("<tr>");
                                print("<td>".$prospects["civilite"].". ".$prospects["nom"]." ".$prospects["prenom"]."</td>");

                                $pays_effectuer = $config->result("DISTINCT `voyages`", $wpdb->prefix.TP_INSSET_BASENAME."_pays_effectuer", "`utilisateur`=".$prospects["id"]);

                                print("<td>".sizeof($pays_effectuer)."</td>");
                                print("</tr>");
                            }
                        ?>
                    </table>
                </form>
            </div>
        </div>
    <?php
    }

    private function toolbar()
    {

    ?>
        <div>
            <form action="<?php print admin_url('admin-post.php'); ?>" method="post">
                <table>
                    <tbody>
                        <tr>
                        <?php if(defined('TP_INSSET_PLUGIN_NAME')) ?>
                            <td>
                                <a class="button button-secondary" href="<?php print plugins_url(TP_INSSET_PLUGIN_NAME.'/classes/export/tp_Insset_Export_CSV.php'); ?>">
                                    <i class="fas fa-save"></i>&nbsp;CSV 
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </div>
<?php

    }
}
