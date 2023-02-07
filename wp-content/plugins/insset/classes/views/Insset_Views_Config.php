<?php

class Insset_Views_Config
{

    public function display()
    {

        $Wp_List = new Insset_Wp_List_Datas();
        $tempscreen = get_current_screen();
        // $this->_screen = $tempscreen->base;
        $configs = Insset_Crud_Index::getConfigs();



?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <hr class="wp-header-end" />
            <div class="notice notice-info notice-alt is-dismissible hide delete-confirmation">
                <p><?php _e('Updated done!'); ?></p>
            </div>
            <div class="wrap" id="list-table">
                <table class="wp-list-table widefat striped">
                    <tfoot>
                        <tr>
                            <th colspan="2">
                                <button class="button button-primary" id="submitConfigForm">
                                    Modifier
                                </button>
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($configs as $config) : ?>
                            <tr>
                                <th class="smallwidth" style="text-transform: capitalize;">
                                    <?php print $config['id'] ?>
                                </th>
                                <td>
                                    <?php if (preg_match('/date/i', $config['id'])) : ?>
                                        <input type="datetime-local" id="<?php print $config['id'] ?>" value="<?php print preg_replace('/\s/', 'T', $config['value']) ?>" />
                                    <?php else : ?>
                                        <input id="<?php print $config['id'] ?>" type="text" value="<?php print $config['value'] ?>" />
                                    <?php endif; ?>
                                    <span class="helper-text">
                                        <?php print $config['description'] ?>
                                    </span>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
        </div>
<?php
    }
}
