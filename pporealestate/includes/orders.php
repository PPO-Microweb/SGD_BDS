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
                echo '<li><a class="', (!isset($_GET['status'])) ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders">Tracking</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '0') ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders&status=0">Pending</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '1') ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders&status=1">Progressing</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '2') ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders&status=2">Completed</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == '3') ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders&status=3">Cancelled</a> | </li>';
                echo '<li><a class="', (isset($_GET['status']) && $_GET['status'] == 'all') ? 'current' : '' ,'" href="?post_type=user_level&page=nvt_orders&status=all">All</a></li>';
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