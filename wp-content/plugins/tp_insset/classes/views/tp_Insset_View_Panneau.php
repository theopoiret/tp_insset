<?php

class tp_Insset_View_Panneau
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
            <div class="wrap" id="list-table">
                Les pays selectionner seront indisponible pour les prospects.
                <form id="list-table-form" method="post">
                    <?php
                    $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
                    $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
                    printf('<input type="hidden" name="page" value="%s" />', $page);
                    printf('<input type="hidden" name="paged" value="%d" />', $paged);
                    ?>
                    <select name="pays[]" id="liste_pays" multiple>
                        <?php
                        foreach($List_pays as $pays){
                            if($pays['actif-inactif'] == 1){
                                printf('<option value="%d" id="choix_pays">'.$pays['pays'].'</option>',$pays['id']);
                            }
                            else{
                                printf('<option value="%d" id="choix_pays" selected>'.$pays['pays'].'</option>',$pays['id']);
                            }
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>
<?php
    }
}
