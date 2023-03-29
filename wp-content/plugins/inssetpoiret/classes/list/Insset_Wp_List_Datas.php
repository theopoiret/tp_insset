<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH .'wp-admin/includes/screen.php');
    require_once(ABSPATH .'wp-admin/includes/class-wp-list-table.php');
}

class INSSETWatisse_List_Datas extends WP_List_Table {

    public $_tablename = '';
    public $_program;
    public $_screen;

    public function __construct($tb, $program = NULL) {

        $this->_program = $program;

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        if ($tb)
            $this->_tablename = $tb;

        parent::__construct( [
            'singular' => __('Item', 'sp'),
            'plural'   => __('Items', 'sp'),
            'ajax'     => false
        ]);

    }

    public function prepare_items() {

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

        $data = array_slice($data, (($currentPage-1)*$perPage), $perPage);

        $this->items = $data;

    }

    public function get_columns($columns = array()) {

        global $wpdb;
        $sub=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribers';
        $data=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribersdata';
        $sql = "SELECT DISTINCT `cle` FROM " .$data. " WHERE `cle` != ''";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        $columns['id'] = __('id');
        $columns['date'] = __('inscription date');
        
        foreach ($result as $value)
            $columns[$value["cle"]] = __($value["cle"]);

        $columns['delete'] = __('delete');
        return $columns;

    }

    public function get_hidden_columns($default = array()) {

        return $default;

    }

    public function get_sortable_columns($sortable = array()) {
        global $wpdb;
        $sub=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribers';
        $data=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribersdata';
        $sql = "SELECT DISTINCT `cle` FROM " . $data . " WHERE `cle` != ''";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $value)
            $sortable[$value["cle"]] = array($value["cle"], true);

        $sortable["id"] = array('id', true);
        $sortable["date"] = array('date', true);

        return $sortable;

    }

    public function table_data($per_page=10, $page_number=1, $orderbydefault=false) {

        global $wpdb;
        $sub=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribers';
        $data=$wpdb->prefix .INSSETPOIRET_BASENAME.'_subscribersdata';

        $sql="SELECT A.*, 
        (SELECT B.`valeur` FROM `".$data."` B WHERE B.`id`=A.`id` AND B.`cle`='firstname' LIMIT 1) AS 'firstname', 
        (SELECT B.`valeur` FROM `".$data."` B WHERE B.`id`=A.`id` AND B.`cle`='email' LIMIT 1) AS 'email',
        (SELECT B.`valeur` FROM `".$data."` B WHERE B.`id`=A.`id` AND B.`cle`='lastname' LIMIT 1) AS 'lastname',
        (SELECT B.`valeur` FROM `".$data."` B WHERE B.`id`=A.`id` AND B.`cle`='postal' LIMIT 1) AS 'postal'
        FROM `".$sub."` A " ;

        if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY `'. esc_sql($_REQUEST['orderby']) .'`';
			$sql .= ! empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;

    }

    public function column_default( $item, $column_name ) {

        if(preg_match('/delete/i',$column_name))
            return self::getDelete($item['id']);

        if(preg_match('/date/i',$column_name))
            return self::getDate($item['date']);
        return @$item[$column_name];

    }

    private function getDelete($id){
        if(!$id)
            return;
        return sprintf(
            '<button data-id="%d" class="deleted"></button>',
        $id);
    }
    private function getDate($date){
        
    }
}