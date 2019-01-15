<?php

if (!class_exists('WP_List_Table'))
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class User_Search_List_Table extends WP_List_Table {

    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
    function __construct() {
        parent::__construct(array(
            'singular' => 'wp_list_user', //Singular label
            'plural' => 'wp_list_users', //plural label, also this well be one of the table css class
            'ajax' => false //We won't support Ajax for this table
        ));
    }

    /**
     * Add extra markup in the toolbars before or after the list
     * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
     */
    function extra_tablenav($which) {
        if ($which == "top") {
            //The code that goes before the table is here
            echo '<div class="ppo-users-filter">';
            echo '<select name="gender">';
            echo '<option value="">- Giới tính -</option>';
            foreach (gender_list() as $key => $value) {
                if(getRequest('gender') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="user_country">';
            echo '<option value="">- Quốc tịch -</option>';
            foreach (country_list() as $key => $value) {
                if(getRequest('user_country') == $value){
                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $value . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="user_city">';
            echo '<option value="">- Quê quán -</option>';
            foreach (vn_city_list() as $key => $value) {
                if(getRequest('user_city') == $value){
                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $value . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="family_status">';
            echo '<option value="">- Gia đình -</option>';
            foreach (family_status() as $key => $value) {
                if(getRequest('family_status') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="edu">';
            echo '<option value="">- Học vấn -</option>';
            foreach (education_list() as $key => $value) {
                if(getRequest('edu') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="chuyen_nganh">';
            echo '<option value="">- Chuyên ngành -</option>';
            foreach (chuyen_nganh_list() as $key => $value) {
                if(getRequest('chuyen_nganh') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="certificates">';
            echo '<option value="">- Chứng chỉ -</option>';
            foreach (get_certificates() as $key => $value) {
                if(getRequest('certificates') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="languages">';
            echo '<option value="">- Ngoại ngữ -</option>';
            foreach (get_languages() as $key => $value) {
                if(getRequest('languages') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="jobs">';
            echo '<option value="">- Nghề nghiệp -</option>';
            foreach (get_jobs() as $key => $value) {
                if(getRequest('jobs') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="regency">';
            echo '<option value="">- Chức danh -</option>';
            foreach (get_regency_list() as $key => $value) {
                if(getRequest('regency') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            echo '<select name="user_exp">';
            echo '<option value="">- Kinh nghiệm -</option>';
            foreach (user_exp_list() as $key => $value) {
                if(getRequest('user_exp') == $key){
                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                } else {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            echo '</select>';
            wp_dropdown_categories(array(
                'show_option_all' => '- Thị trường -',
                'name' => 'bds_segment', 
                'taxonomy' => 'product_category', 
                'selected' => getRequest('bds_segment'),
                'hierarchical' => true,
                'hide_empty' => false,
                'value_field' => 'term_id',
                'class' => '',
                'id' => '',
            ));
            echo '<select name="organizations">';
            echo '<option value="">- Thành viên tổ chức -</option>';
            $organizations = new WP_Query(array(
                'post_type' => 'organization',
                'showposts' => -1,
                'post_status' => 'publish',
                'order' => 'asc'
            ));
            while ($organizations->have_posts()) : $organizations->the_post();
                if(getRequest('organizations') == get_the_ID()){
                    echo '<option value="' . get_the_ID() . '" selected>' . get_the_title() . '</option>';
                } else {
                    echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
                }
            endwhile;
            wp_reset_query();
            echo '</select>';
            echo '<input type="submit" name="finduser" id="finduser" class="button button-primary" value="Tìm">';
            echo '</div>';
        }
        if ($which == "bottom") {
            //The code that goes after the table is there
            //echo"Hi, I'm after the table";
        }
    }

    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    function get_columns() {
        return $columns = array(
//            'col_users_cb' => '<input type="checkbox" class="cb-users-select-all" />',
            'col_users_id' => __('ID', SHORT_NAME),
            'col_users_name' => __('Họ và tên', SHORT_NAME),
            'col_users_phone' => __('Số điện thoại', SHORT_NAME),
            'col_users_email' => __('Địa chỉ Email', SHORT_NAME),
            'col_users_city' => __('Quê quán', SHORT_NAME),
            'col_users_rating' => __('Đánh giá', SHORT_NAME),
//            'col_users_options' => __('Tùy chọn', SHORT_NAME)
        );
    }

    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns() {
        return $sortable = array(
            'col_users_id' => array('ID', true),
            'col_users_name' => array('display_name', false),
        );
    }

    /**
     * Prepare the table with different parameters, pagination, columns and table elements
     */
    function prepare_items() {
        global $wpdb;
        $screen = get_current_screen();
        $tblUsers = $wpdb->users;
        $tblUserMeta = $wpdb->usermeta;

//        $this->process_bulk_action();
        
        /* -- Preparing your query -- */
        $query = "SELECT * FROM $tblUsers ";
        $query_join = "";
        $query_conditions = "";
        if (getRequest('gender')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt1 ON ($tblUsers.ID = mt1.user_id) ";
            $query_conditions .= "AND (mt1.meta_key='gender' AND mt1.meta_value='" . getRequest('gender') . "') ";
        }
        if (getRequest('user_country')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt2 ON ($tblUsers.ID = mt2.user_id) ";
            $query_conditions .= "AND (mt2.meta_key='user_country' AND mt2.meta_value='" . getRequest('user_country') . "') ";
        }
        if (getRequest('user_city')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt3 ON ($tblUsers.ID = mt3.user_id) ";
            $query_conditions .= "AND (mt3.meta_key='user_city' AND mt3.meta_value='" . getRequest('user_city') . "') ";
        }
        if (getRequest('family_status')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt4 ON ($tblUsers.ID = mt4.user_id) ";
            $query_conditions .= "AND (mt4.meta_key='family_status' AND mt4.meta_value='" . getRequest('family_status') . "') ";
        }
        if (getRequest('edu')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt5 ON ($tblUsers.ID = mt5.user_id) ";
            $query_conditions .= "AND (mt5.meta_key='edu' AND mt5.meta_value='" . getRequest('edu') . "') ";
        }
        if (getRequest('chuyen_nganh')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt6 ON ($tblUsers.ID = mt6.user_id) ";
            $query_conditions .= "AND (mt6.meta_key='chuyen_nganh' AND mt6.meta_value LIKE '%" . getRequest('chuyen_nganh') . "%') ";
        }
        if (getRequest('certificates')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt7 ON ($tblUsers.ID = mt7.user_id) ";
            $query_conditions .= "AND (mt7.meta_key='certificates' AND mt7.meta_value LIKE '%" . getRequest('certificates') . "%') ";
        }
        if (getRequest('languages')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt8 ON ($tblUsers.ID = mt8.user_id) ";
            $query_conditions .= "AND (mt8.meta_key='languages' AND mt8.meta_value LIKE '%" . getRequest('languages') . "%') ";
        }
        if (getRequest('jobs')) {
            $query_join .= "INNER JOIN $tblUserMeta AS mt9 ON ($tblUsers.ID = mt9.user_id) ";
            $query_conditions .= "AND (mt9.meta_key='jobs' AND mt9.meta_value LIKE '%" . getRequest('jobs') . "%') ";
        }
        if (getRequest('regency')) {
            $query_join .= "INNER JOIN $tblUserMeta AS m10 ON ($tblUsers.ID = m10.user_id) ";
            $query_conditions .= "AND (m10.meta_key='regency' AND m10.meta_value LIKE '%" . getRequest('regency') . "%') ";
        }
        if (getRequest('user_exp')) {
            $query_join .= "INNER JOIN $tblUserMeta AS m11 ON ($tblUsers.ID = m11.user_id) ";
            $query_conditions .= "AND (m11.meta_key='user_exp' AND m11.meta_value='" . getRequest('user_exp') . "') ";
        }
        if (getRequest('bds_segment')) {
            $query_join .= "INNER JOIN $tblUserMeta AS m12 ON ($tblUsers.ID = m12.user_id) ";
            $query_conditions .= "AND ( (m12.meta_key='bds_segment1' AND m12.meta_value='" . getRequest('bds_segment') . "') OR "
                              . "(m12.meta_key='bds_segment2' AND m12.meta_value='" . getRequest('bds_segment') . "') OR "
                              . "(m12.meta_key='bds_segment3' AND m12.meta_value='" . getRequest('bds_segment') . "') ) ";
        }
        if (getRequest('organizations')) {
            $query_join .= "INNER JOIN $tblUserMeta AS m13 ON ($tblUsers.ID = m13.user_id) ";
            $query_conditions .= "AND (m13.meta_key='organizations' AND m13.meta_value REGEXP '.*;s:[0-9]+:\"" . getRequest('organizations') . "\".*') ";
        }
        if(!empty($query_join)){
            $query .= "$query_join WHERE 1=1 $query_conditions ";
        }

        /* -- Ordering parameters -- */
        //Parameters that are going to be used to order the result
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ID';
        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : 'DESC';
        if (!empty($orderby) & !empty($order)) {
            $query.=' ORDER BY ' . $orderby . ' ' . $order;
        }

        /* -- Pagination parameters -- */
        //Number of elements in your table?
        $totalitems = $wpdb->query($query); //return the total number of affected rows
        //How many to display per page?
        $perpage = 50;
        //Which page is this?
        //$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
        $paged = $this->get_pagenum();
        //Page Number
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        //How many pages do we have in total?
        $totalpages = ceil($totalitems / $perpage);
        //adjust the query to take pagination into account
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query.=' LIMIT ' . (int) $offset . ',' . (int) $perpage;
        }

        /* -- Register the pagination -- */
        $this->set_pagination_args(array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage,
        ));
        //The pagination links are automatically built according to those parameters

        /* -- Register the Columns -- */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        /* -- Fetch the items -- */
        $this->items = $wpdb->get_results($query);
    }

    /**
     * Display the rows of records in the table
     * @return string, echo the markup of the rows
     */
    function display_rows() {

        //Get the records registered in the prepare_items method
        $records = $this->items;

        //Get the columns registered in the get_columns and get_sortable_columns methods
        list( $columns, $hidden ) = $this->get_column_info();

        //Loop for each record
        if (!empty($records)) {
            foreach ($records as $rec) {

                //Open the line
                echo '<tr id="record_' . $rec->ID . '">';
                foreach ($columns as $column_name => $column_display_name) {

                    //Style attributes for each col
                    $class = "class='$column_name column-$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden))
                        $style = ' style="display:none;"';
                    $attributes = $class . $style;

                    //Display the cell
                    switch ($column_name) {
//                        case "col_users_cb": echo '<th ' . $attributes . '>' . $this->column_cb($rec) . '</th>';
//                            break;
                        case "col_users_id": echo '<td ' . $attributes . '>' . $rec->ID . '</td>';
                            break;
                        case "col_users_name":
                            echo '<td ' . $attributes . '>';
                            echo '<a href="user-edit.php?user_id='.$rec->ID.'" target="_blank">';
                            echo $rec->display_name;
                            echo '</a>';
                            echo '</td>';
                            break;
                        case "col_users_phone": echo '<td ' . $attributes . '>' . get_the_author_meta( 'phone', $rec->ID ) . '</td>';
                            break;
                        case "col_users_email": echo '<td ' . $attributes . '>' . $rec->user_email . '</td>';
                            break;
                        case "col_users_city": echo '<td ' . $attributes . '>' . get_the_author_meta( 'user_city', $rec->ID ) . '</td>';
                            break;
                        case "col_users_rating": echo '<td ' . $attributes . '>';
                            echo '<div class="ratings">';
                            echo ppo_user_ratings($rec->ID);
                            echo '</div></td>';
                            break;
//                        case "col_users_options": 
//                            echo '<td ' . $attributes . '>';
//                            echo '</td>';
//                            break;
                    }
                }

                //Close the line
                echo'</tr>';
            }
        }
    }
    
    function get_bulk_actions() {
        return false;
//        return array(
//            'delete'   => __('Delete', SHORT_NAME),
//        );
    }
    
    function process_bulk_action() {
        global $wpdb;
        $tblUsers = $wpdb->users;
        
        // security check!
        if (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce'])) {
            $nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
            $action = 'bulk-' . $this->_args['plural'];

            if (!wp_verify_nonce($nonce, $action))
                wp_die('Nope! Security check failed!');
        }

        $action = $this->current_action();
        $wp_list_users = getRequest('wp_list_order');
        
        switch ($action) {
            case "delete":
                foreach ($wp_list_users as $id) {
                    $query = "DELETE FROM $tblUsers WHERE ID = $id";
                    $wpdb->query($query); 
                }
                break;
            default:
                break;
        }

        return;
    }
    
    function column_default($item, $column_name) {
        return '';
    }
    
    function column_cb($item) {
        return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $item->ID );
    }

}

################################################################################
add_action('admin_print_footer_scripts', 'users_bulk_actions_select_all', 99);

function users_bulk_actions_select_all() {
    echo <<<HTML
<style type="text/css">
    #col_users_cb{width: 30px;}
    #col_users_id{width: 50px;}
</style>
<script type="text/javascript">/* <![CDATA[ */
jQuery(function($){
    $("input.cb-users-select-all").click(function(){
        if($(this).is(':checked')){
            $("input[name='wp_list_order[]']").attr('checked', 'checked');
            $("input.cb-users-select-all").attr('checked', 'checked');
        }else{
            $("input[name='wp_list_order[]']").removeAttr('checked');
            $("input.cb-users-select-all").removeAttr('checked');
        }
    });
});
/* ]]> */
</script>
HTML;
}