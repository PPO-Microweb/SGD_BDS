<?php

function project_status(){
    return array(
        'soon' => __('Sắp mở bán', SHORT_NAME),
        'open' => __('Đang mở bán', SHORT_NAME),
        'close' => __('Hết hàng', SHORT_NAME),
    );
}

function supplier_list() {
    $result = array('' => '- Chọn nhà cung cấp -');
    if(is_admin()){
        $projects = new WP_Query(array(
            'post_type' => 'supplier',
            'showposts' => -1,
            'post_status' => 'publish',
        ));
        while($projects->have_posts()): $projects->the_post();
            $result[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();
    }
    return $result;
}

/* ----------------------------------------------------------------------------------- */
# Create post_type
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_project_post_type');

function create_project_post_type() {
    register_post_type('project', array(
        'labels' => array(
            'name' => __('Dự án'),
            'singular_name' => __('Projects'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Project'),
            'new_item' => __('New Project'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Project'),
            'view' => __('View Project'),
            'view_item' => __('View Project'),
            'search_items' => __('Search Projects'),
            'not_found' => __('No Project found'),
            'not_found_in_trash' => __('No Project found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'author', 'thumbnail', 
            //'custom-fields', 'comments', 'excerpt',
        ),
        'rewrite' => array('slug' => 'du-an', 'with_front' => false),
        'can_export' => true,
        'description' => __('Project description here.'),
        'taxonomies' => array('post_tag'),
    ));
}

/* ----------------------------------------------------------------------------------- */
# Create taxonomy
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_project_taxonomies');

function create_project_taxonomies() {
    register_taxonomy('project_category', 'project', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Loại dự án'),
            'singular_name' => __('Project Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
        'rewrite' => array('slug' => 'loai-du-an', 'with_front' => false),
    ));
    register_taxonomy('project_level', 'project', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Hạng dự án'),
            'singular_name' => __('Hạng dự án'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Thêm mới Hạng dự án'),
            'new_item' => __('Hạng dự án mới'),
            'search_items' => __('Tìm kiếm Hạng dự án'),
        ),
        'rewrite' => array('slug' => 'hang-du-an', 'with_front' => false),
    ));
}

add_action('init', 'create_project_taxonomies');

/* ----------------------------------------------------------------------------------- */
# Meta box
/* ----------------------------------------------------------------------------------- */
$list_city = get_province();
$temp_city = array('' => '- Chọn Tỉnh/Thành phố -');
foreach ($list_city as $ct) {
    $temp_city[$ct->provinceid] = $ct->name;
}
$project_meta_box = array(
    'id' => 'project-meta-box',
    'title' => 'Thông tin dự án',
    'page' => 'project',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Giá',
            'desc' => 'Ví dụ: từ 1.2-3.6 tỷ',
            'id' => 'project_price',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Diện tích',
            'desc' => 'Ví dụ: từ 45-150m2',
            'id' => 'project_area',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Thành phố',
            'desc' => '',
            'id' => 'city',
            'type' => 'select',
            'std' => '',
            'options' =>$temp_city,
        ),
        array(
            'name' => 'Quận / Huyện',
            'desc' => '',
            'id' => 'district',
            'type' => 'select',
            'std' => '',
            'options' =>'',
        ),
        array(
            'name' => 'Phường/Xã',
            'desc' => '',
            'id' => 'ward',
            'type' => 'select',
            'std' => '',
            'options' =>'',
        ),
        array(
            'name' => 'Khu vực',
            'desc' => 'Ví dụ: Lê Văn Lương',
            'id' => 'khu_vuc',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Nhà cung cấp',
            'desc' => '',
            'id' => 'supplier',
            'type' => 'select',
            'std' => '',
            'options' => supplier_list(),
        ),
        array(
            'name' => 'Tình trạng',
            'desc' => '',
            'id' => 'status',
            'type' => 'radio',
            'std' => '',
            'options' => project_status(),
        ),
    )
);
 //Add project meta box
if (is_admin()) {
    add_action('admin_menu', 'project_add_box');
    add_action('save_post', 'project_add_box');
    add_action('save_post', 'project_save_data');
}

function project_add_box() {
    global $project_meta_box;
    add_meta_box($project_meta_box['id'], $project_meta_box['title'], 'project_show_box', $project_meta_box['page'], $project_meta_box['context'], $project_meta_box['priority']);
}

/**
 * Callback function to show fields in project meta box
 * @global array $project_meta_box
 * @global Object $post
 * @global array $area_fields
 */
function project_show_box() {
    global $project_meta_box, $post;
    custom_output_meta_box($project_meta_box, $post);
}

/**
 * Save data from project meta box
 * @global array $project_meta_box
 * @global array $area_fields
 * @param Object $post_id
 * @return 
 */
function project_save_data($post_id) {
    global $project_meta_box;
    custom_save_meta_box($project_meta_box, $post_id);
    return $post_id;
}

// ADD NEW COLUMN  
function project_columns_head($defaults) {
    unset($defaults['comments']);
    unset($defaults['date']);
    $defaults['cat'] = __('Loại dự án', SHORT_NAME);
    $defaults['level'] = __('Hạng dự án', SHORT_NAME);
    $defaults['date'] = __('Ngày đăng');
    return $defaults;
}

// SHOW THE COLUMN
function project_columns_content($column_name, $post_id) {
    switch ($column_name) {
        case 'cat':
            $taxonomy = 'project_category';
            $terms = get_the_terms($post_id, $taxonomy);
            if(is_array($terms)){
                foreach ($terms as $key => $term) {
                    echo '<a href="' . get_edit_tag_link($term->term_id, $taxonomy) . '" target="_blank">' . $term->name . '</a>';
                    if($key < count($terms) - 1){
                        echo ", ";
                    }
                }
            }
            break;
        case 'level':
            $taxonomy = 'project_level';
            $terms = get_the_terms($post_id, $taxonomy);
            if(is_array($terms)){
                foreach ($terms as $key => $term) {
                    echo '<a href="' . get_edit_tag_link($term->term_id, $taxonomy) . '" target="_blank">' . $term->name . '</a>';
                    if($key < count($terms) - 1){
                        echo ", ";
                    }
                }
            }
            break;
        default:
            break;
    }
}

add_filter('manage_project_posts_columns', 'project_columns_head');  
add_action('manage_project_posts_custom_column', 'project_columns_content', 10, 2); 