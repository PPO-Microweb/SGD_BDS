<?php

/**
 * User Level Menu Page
 */

# Custom user_level post type
add_action('init', 'create_user_level_post_type');

function create_user_level_post_type(){
    register_post_type('user_level', array(
        'labels' => array(
            'name' => __('User Levels', SHORT_NAME),
            'singular_name' => __('User Levels', SHORT_NAME),
            'add_new' => __('Add new', SHORT_NAME),
            'add_new_item' => __('Add new Level', SHORT_NAME),
            'new_item' => __('New Level', SHORT_NAME),
            'edit' => __('Edit', SHORT_NAME),
            'edit_item' => __('Edit Level', SHORT_NAME),
            'view' => __('View Level', SHORT_NAME),
            'view_item' => __('View Level', SHORT_NAME),
            'search_items' => __('Search Levels', SHORT_NAME),
            'not_found' => __('No Level found', SHORT_NAME),
            'not_found_in_trash' => __('No Level found in trash', SHORT_NAME),
        ),
        'public' => false,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 
            //'custom-fields', 'author', 'excerpt', 'comments', 'thumbnail', 
        ),
        'rewrite' => array('slug' => 'user_level', 'with_front' => false),
        'can_export' => true,
//        'has_archive' => true,
        'description' => __('Supplier description here.')
    ));
}