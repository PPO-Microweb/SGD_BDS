<?php

/**
 * Blocks Menu Page
 */

# Custom block post type
add_action('init', 'create_block_post_type');

function create_block_post_type(){
    register_post_type('block', array(
        'labels' => array(
            'name' => __('Blocks', SHORT_NAME),
            'singular_name' => __('Blocks', SHORT_NAME),
            'add_new' => __('Add new', SHORT_NAME),
            'add_new_item' => __('Add new Block', SHORT_NAME),
            'new_item' => __('New Block', SHORT_NAME),
            'edit' => __('Edit', SHORT_NAME),
            'edit_item' => __('Edit Block', SHORT_NAME),
            'view' => __('View Block', SHORT_NAME),
            'view_item' => __('View Block', SHORT_NAME),
            'search_items' => __('Search Blocks', SHORT_NAME),
            'not_found' => __('No Block found', SHORT_NAME),
            'not_found_in_trash' => __('No Block found in trash', SHORT_NAME),
        ),
        'public' => false,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 
            //'custom-fields', 'author', 'excerpt', 'comments',  'editor','thumbnail', 
        ),
        'rewrite' => array('slug' => 'block', 'with_front' => false),
        'can_export' => true,
//        'has_archive' => true,
        'description' => __('Block description here.')
    ));
}

/* ----------------------------------------------------------------------------------- */
# Meta box
/* ----------------------------------------------------------------------------------- */
$block_meta_box = array(
    'id' => 'block-meta-box',
    'title' => 'Information',
    'page' => 'block',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Phân khúc',
            'desc' => '',
            'id' => 'segment',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Link BĐS',
            'desc' => '',
            'id' => 'link_bds',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Link Block',
            'desc' => '',
            'id' => 'link_block',
            'type' => 'text',
            'std' => '',
        ),
    )
);

//Add block meta box
if (is_admin()) {
    add_action('admin_menu', 'block_add_box');
    add_action('save_post', 'block_add_box');
    add_action('save_post', 'block_save_data');
}

function block_add_box() {
    global $block_meta_box;
    add_meta_box($block_meta_box['id'], $block_meta_box['title'], 'block_show_box', $block_meta_box['page'], $block_meta_box['context'], $block_meta_box['priority']);
}

function block_show_box() {
    global $block_meta_box, $post;
    custom_output_meta_box($block_meta_box, $post);
}

function block_save_data($post_id) {
    global $block_meta_box;
    custom_save_meta_box($block_meta_box, $post_id);
    return $post_id;
}
