<?php

add_action('admin_menu', 'add_user_sort_page');

/* ----------------------------------------------------------------------------------- */
# Add user statistics page menu
/* ----------------------------------------------------------------------------------- */
function add_user_sort_page(){
//    add_menu_page(__('Thống kê thành viên', SHORT_NAME), // Page title
//            __('Thống kê thành viên', SHORT_NAME), // Menu title
//            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
//            'user_sort', // menu id - Unique id of the menu
//            'theme_user_sort_page',// render output function
//            null, // URL icon, if empty default icon
//            null // Menu position - integer, if null default last of menu list
//        );
    add_submenu_page('users.php', //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Xếp hạng thành viên', SHORT_NAME), // Page title
            __('Xếp hạng thành viên', SHORT_NAME), // Menu title
            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'user_sort', // Submenu ID – Unique id of the submenu.
            'theme_user_sort_page' // render output function
        );
}

/* ----------------------------------------------------------------------------------- */
# Orders layout
/* ----------------------------------------------------------------------------------- */
function theme_user_sort_page() {
    include_once 'class-user_sort-list-table.php';

    echo <<<HTML
    <div class="wrap user-search-wrap">
        <div id="icon-users" class="icon32"></div>
        <h2>Xếp hạng thành viên</h2>
        <form action="" method="get">
            <input type="hidden" name="page" value="user_sort" />
HTML;

    //Prepare Table of elements
    $wp_list_table = new User_Sort_List_Table();
    $wp_list_table->prepare_items();
    //Table of elements
    $wp_list_table->display();

    echo '</form></div>';
}