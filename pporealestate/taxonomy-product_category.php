<?php 
$trantype = getRequest('trantype');
$taxonomy = 'product_category';
$term = get_queried_object();
$term_id = $term->term_id;
$tax_meta = get_option("cat_{$term->term_id}");
get_header(); 
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
                            <?php
                            if($trantype == 'sell'){
                                _e('Cần bán', SHORT_NAME);
                            } else if($trantype == 'rent'){
                                _e('Cho thuê', SHORT_NAME);
                            } else if($trantype == 'invest'){
                                _e('Đầu tư', SHORT_NAME);
                            }
                            single_cat_title();
                            ?>
                        </h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php 
                    while (have_posts()) : the_post();
                        get_template_part('template', 'product_item');
                    endwhile;
                    getpagenavi();
                    ?>
                </div>
            </div>
        </div>
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_template_part('template/widget-district-list'); ?>
            <?php get_template_part('template', 'sidebarsearch'); ?>
            <?php
            $ancestors = get_ancestors($term_id, $taxonomy); // Get a list of ancestors
            $ancestors = array_reverse($ancestors); //Reverse the array to put the top level ancestor first
            $ancestors[0] ? $top_term_id = $ancestors[0] : $top_term_id = $term_id; //Check if there is an ancestor, else use id of current term

            $term = get_term($top_term_id, $taxonomy); //Get the term
            $parent = $term->term_id; // id of top level ancestor
            $args = array(
                'child_of' => $parent,
                'taxonomy' => 'product_category',
                'hide_empty' => 1,
            );
            $terms = get_terms($taxonomy, $args);
            if(count($terms) > 0):
            ?>
            <div class="widget child_category">
                <h3 class="widget-title"><?php echo $term->name ?></h3>
                <div class="child_content">
                    <ul class="child">
                    <?php 
                    foreach ($terms as $term) {
                        echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <?php if ( is_active_sidebar( 'sidebar_product' ) ) { dynamic_sidebar( 'sidebar_product' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
