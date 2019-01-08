<?php

/**
 * Organizations Menu Page
 */

# Custom organization post type
add_action('init', 'create_organization_post_type');

function create_organization_post_type(){
    register_post_type('organization', array(
        'labels' => array(
            'name' => __('Các đơn vị/Tổ chức', SHORT_NAME),
            'singular_name' => __('Các đơn vị/Tổ chức', SHORT_NAME),
            'add_new' => __('Add new', SHORT_NAME),
            'add_new_item' => __('Add new Organization', SHORT_NAME),
            'new_item' => __('New Organization', SHORT_NAME),
            'edit' => __('Edit', SHORT_NAME),
            'edit_item' => __('Edit Organization', SHORT_NAME),
            'view' => __('View Organization', SHORT_NAME),
            'view_item' => __('View Organization', SHORT_NAME),
            'search_items' => __('Search Organizations', SHORT_NAME),
            'not_found' => __('No Organization found', SHORT_NAME),
            'not_found_in_trash' => __('No Organization found in trash', SHORT_NAME),
        ),
        'public' => false,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'thumbnail', 
            //'custom-fields', 'author', 'excerpt', 'comments', 
        ),
        'rewrite' => array('slug' => 'organization', 'with_front' => false),
        'can_export' => true,
//        'has_archive' => true,
        'description' => __('Organization description here.')
    ));
}