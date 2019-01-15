<?php 
/*
  Template Name: Tin theo dõi
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header();
global $current_user;
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
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php
                    $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $products_per_page,
                        'author' => $user_id,
                        'orderby' => array('meta_value_num', 'post_date'),
                        'meta_key' => 'not_in_vip',
                        'order' => 'DESC',
                        'tax_query' => array(
                            'relation' => 'AND',
                        ),
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'end_time',
                                'value' => date('Y/m/d', strtotime("today")),
                                'compare' => '>=',
                                'type' => 'DATE'
                            )
                        ),
                    );
                    $bds_segment1 = get_the_author_meta( 'bds_segment1', $current_user->ID );
                    $bds_segment2 = get_the_author_meta( 'bds_segment2', $current_user->ID );
                    $bds_segment3 = get_the_author_meta( 'bds_segment3', $current_user->ID );
                    $bds_location1 = get_the_author_meta( 'bds_location1', $current_user->ID );
                    $bds_location2 = get_the_author_meta( 'bds_location2', $current_user->ID );
                    $bds_location3 = get_the_author_meta( 'bds_location3', $current_user->ID );
                    $terms = array();
                    $meta_values = array();
                    if(!empty($bds_segment1)){
                        $terms[] = $bds_segment1;
                    }
                    if(!empty($bds_segment2) and !in_array($bds_segment2, $terms)){
                        $terms[] = $bds_segment2;
                    }
                    if(!empty($bds_segment3) and !in_array($bds_segment3, $terms)){
                        $terms[] = $bds_segment3;
                    }
                    if(!empty($bds_location1)){
                        $meta_values[] = $bds_location1;
                    }
                    if(!empty($bds_location2) and !in_array($bds_location2, $meta_values)){
                        $meta_values[] = $bds_location2;
                    }
                    if(!empty($bds_location3) and !in_array($bds_location3, $meta_values)){
                        $meta_values[] = $bds_location3;
                    }
                    if(!empty($terms)){
                        $args['tax_query'][] = array(
                            'taxonomy' => 'product_category',
                            'field'    => 'term_id',
                            'terms'    => $terms,
                        );
                    }
                    if(!empty($meta_values)){
                        $args['meta_query'][] = array(
                            'key' => 'district',
                            'value' => $meta_values,
                            'compare' => 'IN',
                        );
                    }
                    $loop = new WP_Query($args);
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
            <?php if ( is_active_sidebar( 'sidebar_product' ) ) { dynamic_sidebar( 'sidebar_product' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
