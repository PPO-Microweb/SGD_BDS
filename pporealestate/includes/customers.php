<?php

add_action('after_setup_theme', 'customers_install');
add_action('admin_menu', 'add_customers_page');

/* ----------------------------------------------------------------------------------- */
# Create table in database
/* ----------------------------------------------------------------------------------- */
if (!function_exists('customers_install')) {
    function customers_install() {
        global $wpdb;
        
        $customers = $wpdb->prefix . 'customers';

        $sql = "CREATE TABLE IF NOT EXISTS $customers (
                ID int AUTO_INCREMENT PRIMARY KEY,
                fullname varchar(100) character set utf8 NULL,
                phone varchar(25) character set utf8 NULL,
                email varchar(100) character set utf8 NULL,
                message longtext character set utf8 NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_date DATETIME NOT NULL
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/* ----------------------------------------------------------------------------------- */
# Add customers page menu
/* ----------------------------------------------------------------------------------- */
function add_customers_page(){
    add_menu_page(__('Danh sách người liên hệ', SHORT_NAME), // Page title
            __('Khách hàng', SHORT_NAME), // Menu title
            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'nvt_customers', // menu id - Unique id of the menu
            'theme_customers_page',// render output function
            null, // URL icon, if empty default icon
            null // Menu position - integer, if null default last of menu list
        );
}

/* ----------------------------------------------------------------------------------- */
# Orders layout
/* ----------------------------------------------------------------------------------- */
function theme_customers_page() {
    include_once 'class-customers-list-table.php';

    echo <<<HTML
    <div class="wrap">
        <div id="icon-users" class="icon32"></div>
        <h2>Danh sách người liên hệ</h2>
        <form action="" method="get">
            <input type="hidden" name="page" value="nvt_customers" />
HTML;

    //Prepare Table of elements
    $wp_list_table = new WP_Customers_List_Table();
    $wp_list_table->prepare_items();
    //Table of elements
    $wp_list_table->display();

    echo '</form></div>';
}