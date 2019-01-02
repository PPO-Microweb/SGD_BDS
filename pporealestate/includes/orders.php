<?php

add_action('after_setup_theme', 'orders_install');
add_action('admin_menu', 'add_orders_page');

/* ----------------------------------------------------------------------------------- */
# Create table in database
/* ----------------------------------------------------------------------------------- */
if (!function_exists('orders_install')) {
    function orders_install() {
        global $wpdb;
        
        $orders = $wpdb->prefix . 'orders';

        $sql = "CREATE TABLE IF NOT EXISTS $orders (
                ID int AUTO_INCREMENT PRIMARY KEY,
                user_id int NOT NULL,
                level_id int NOT NULL,
                order_status int default 0 comment '0: pending, 1: progressing, 2: completed, 3: cancelled',
                payment_status int default 0 comment '0: pending, 1: paid, 2: cancelled',
                payment_method varchar(255) character set utf8 NOT NULL,
                discount decimal default 0 NOT NULL,
                total_amount decimal default 0 NOT NULL,
                notes longtext character set utf8 NOT NULL,
                nl_payment_id varchar(255) NULL,
                nl_payment_type varchar(255) NULL,
                nl_secure_code varchar(255) NULL,
                affiliate_id varchar(100) NULL,
                affiliate_trans_id varchar(255) character set utf8 NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_date DATETIME NOT NULL
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/* ----------------------------------------------------------------------------------- */
# Add orders page menu
/* ----------------------------------------------------------------------------------- */
function add_orders_page(){
    global $fields;
    
//    add_menu_page(__('Quản lý đơn hàng', SHORT_NAME), // Page title
//            __('Đơn hàng', SHORT_NAME), // Menu title
//            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
//            'nvt_orders', // menu id - Unique id of the menu
//            'theme_orders_page',// render output function
//            get_template_directory_uri() . '/libs/images/cart.png', // URL icon, if empty default icon
//            null // Menu position - integer, if null default last of menu list
//        );
    add_submenu_page('edit.php?post_type=user_level', //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Quản lý đơn hàng', SHORT_NAME), // Page title
            __('Đơn hàng', SHORT_NAME), // Menu title
            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'nvt_orders', // Submenu ID – Unique id of the submenu.
            'theme_orders_page' // render output function
        );
    /*-------------------------------------------------------------------------*/
    # Update data
    /*-------------------------------------------------------------------------*/
    if (isset($_GET['page']) and $_GET['page'] == 'nvt_orders') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($fields as $field) {
                update_option($field, $_REQUEST[$field]);
            }
            foreach ($fields as $field) {
                if (isset($_REQUEST[$field])) {
                    update_option($field, $_REQUEST[$field]);
                } else {
                    delete_option($field);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
}

/* ----------------------------------------------------------------------------------- */
# Orders layout
/* ----------------------------------------------------------------------------------- */
function theme_orders_page() {
    if(isset($_GET['action']) and $_GET['action'] == 'view-detail'){
        include_once 'class-orders-detail-list-table.php';

        echo <<<HTML
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Thông tin khách hàng</h2>
HTML;

        //Prepare Table of elements
        $wp_list_table = new WPOrders_Detail_List_Table();
        $wp_list_table->prepare_items();
        //Table of elements
        $wp_list_table->display();

        echo '</div>';
    }else{
        include_once 'class-orders-list-table.php';

        echo <<<HTML
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Orders List</h2>
            <ul class="subsubsub">
HTML;
                echo '<li><a class="', (!isset($_GET['status'])) ? 'current' : '' ,'" href="?page=nvt_orders">Tracking</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '0') ? 'current' : '' ,'" href="?page=nvt_orders&status=0">Pending</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '1') ? 'current' : '' ,'" href="?page=nvt_orders&status=1">Progressing</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '2') ? 'current' : '' ,'" href="?page=nvt_orders&status=2">Completed</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '3') ? 'current' : '' ,'" href="?page=nvt_orders&status=3">Cancelled</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == 'all') ? 'current' : '' ,'" href="?page=nvt_orders&status=all">All</a></li>';
        echo <<<HTML
            </ul>
            <form action="" method="get">
            <input type="hidden" name="page" value="nvt_orders" />
HTML;

        //Prepare Table of elements
        $wp_list_table = new WPOrders_List_Table();
        $wp_list_table->prepare_items();
        //Table of elements
        $wp_list_table->display();

        echo '</form></div>';
    }
}
/**
 * 
 * @param double $sale_amt The sale amount. You get this value from your payment gateway or the shopping cart
 * @param int $item_id order id
 * @param string $buyer_email
 */
function PPOAffAwardingCommission($order_id) {
    global $wpdb;
    $tblOrders = $wpdb->prefix . 'orders';
    
    $ordersRow = $wpdb->get_row( "SELECT * FROM $tblOrders WHERE ID = $order_id" );
    $affiliate_id = $ordersRow->affiliate_id;
    $affiliate_trans_id = $ordersRow->affiliate_trans_id;
    if($affiliate_id != "" and $affiliate_id != null and ($affiliate_trans_id == "" or $affiliate_trans_id == null)){
        $customer_info = json_decode($ordersRow->customer_info);

        // The Post URL (Get this value from the settings menu of this plugin)
        $postURL = get_option('wp_aff_comm_post_url');

        // The Secret key (Get this value from the settings menu of this plugin)
        $secretKey = get_option('wp_aff_secret_word_for_post');

        $txn_id = random_string(13);

        // Prepare the data
        $data = array();
        $data['secret'] = $secretKey;
        $data['ap_id'] = $affiliate_id;
        $data['sale_amt'] = $ordersRow->total_amount;
        $data['item_id'] = $order_id;
        $data['buyer_email'] = $customer_info->email;
        $data['buyer_name'] = $customer_info->fullname;
        $data['txn_id'] = $txn_id;

        // send data to post URL to award the commission
        $ch = curl_init($postURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnValue = curl_exec($ch);
        curl_close($ch);

        $query = "UPDATE $tblOrders SET affiliate_trans_id = '$txn_id' WHERE ID = $order_id";
        $wpdb->query($query);
    }
}
function PPOAffRemoveCommission($order_id){
    if(function_exists("wp_aff_delete_sales_data")){
        global $wpdb;
        $tblOrders = $wpdb->prefix . 'orders';

        $txn_id = $wpdb->get_var( "SELECT affiliate_trans_id FROM $tblOrders WHERE ID = $order_id" );
        if($txn_id){
            wp_aff_delete_sales_data($txn_id);
            $query = "UPDATE $tblOrders SET affiliate_trans_id = '' WHERE ID = $order_id";
            $wpdb->query($query);
        }
    }
    return $order_id;
}
