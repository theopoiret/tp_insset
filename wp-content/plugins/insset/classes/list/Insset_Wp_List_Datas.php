<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/screen.php');
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Insset_Wp_List_Datas extends WP_List_Table
{

    public $_program;
    public $_screen;

    public function __construct($program = NULL)
    {

        $this->_program = $program;

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;


        parent::__construct([
            'singular' => __('Item', 'sp'),
            'plural'   => __('Items', 'sp'),
            'ajax'     => false
        ]);
    }

    public function prepare_items()
    {

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->table_data();
        $currentPage = $this->get_pagenum();

        $perPage = 10;
        $this->set_pagination_args(array(
            'total_items' => count($data),
            'per_page'    => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->items = $data;
    }

    public function get_columns($columns = array())
    {
        global $wpdb;

        $sql = "SELECT DISTINCT `key_of_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " WHERE `key_of_values` != ''";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        $columns['id'] = __('id');
        $columns['date'] = __('inscription date');

        foreach ($result as $value)
            $columns[$value["key_of_values"]] = __($value["key_of_values"]);

        $columns['delete'] = __('');

        return $columns;
    }

    public function get_hidden_columns($default = array())
    {

        return $default;
    }

    public function get_sortable_columns($sortable = array())
    {
        global $wpdb;

        $sql = "SELECT DISTINCT `key_of_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " WHERE `key_of_values` != ''";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $value)
            $sortable[$value["key_of_values"]] = array($value["key_of_values"], true);

        $sortable["id"] = array('id', true);
        $sortable["date"] = array('date', true);

        return $sortable;
    }

    public function table_data($per_page = 10, $page_number = 1, $orderbydefault = false)
    {

        global $wpdb;

        // $sql = 'SELECT * FROM `' . $wpdb->prefix . INSSET_BASENAME . '_newsletter' . '`';

        $sql = "SELECT A.*, 
            (SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='firstname' LIMIT 1) AS 'firstname', 
            (SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='email' LIMIT 1) AS 'email',
            (SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='username' LIMIT 1) AS 'username',
            (SELECT B.`key_values` FROM " . $wpdb->prefix . INSSET_BASENAME . '_sub_table_newsletter' . " B WHERE B.`id`=A.`id` AND B.`key_of_values`='adress' LIMIT 1) AS 'adress'
            FROM " . $wpdb->prefix . INSSET_BASENAME . '_newsletter' . " A ";


        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY `' . esc_sql($_REQUEST['orderby']) . '`';
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public function column_default($item, $column_name)
    {
        if (preg_match('/delete/i', $column_name))
            return self::get_delete($item['id']);

        if (preg_match('/date/i', $column_name))
            return self::get_date($item['date']);

        return @$item[$column_name];
    }

    private function get_delete($id = 0)
    {
        if (!$id)
            return;

        printf(
            "<button data-id=$id class='button button-secondary button-small deleteButton'></button>"
        );

        // if ($id == 9) {
        //     $Insset_Crud_Index = new Insset_Crud_Index();
        //     print($Insset_Crud_Index->remove(9));
        // }
    }

    private function get_date($date = 0)
    {
        printf(
            date("F jS Y H:i", strtotime($date))
        );
    }
}
