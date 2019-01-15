<?php
/*
  Template Name: Manage Posts
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header(); 

global $current_user;
$user_id = $current_user->ID;
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-12">
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="span-title">
                            <?php _e('Quản lý tin đăng', SHORT_NAME) ?>
                        </h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php
                    $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
                    $loop = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => $products_per_page,
                        'author' => $user_id,
                        'orderby' => array('meta_value_num', 'post_date'),
                        'meta_key' => 'not_in_vip',
                        'order' => 'DESC',
                    ));
                    while ($loop->have_posts()) : $loop->the_post();
                        get_template_part('template', 'product_item3');
                    endwhile;
                    getpagenavi(array('query' => $loop));
                    ?>
                </div>
            </div>
        </div>
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_template_part('template/widget-district-list'); ?>
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
