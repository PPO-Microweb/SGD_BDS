<?php  get_header(); ?>
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
                            $trantype = getRequest('trantype');
                            if($trantype == 'sell'){
                                _e('Bất động sản cần bán', SHORT_NAME);
                            } else if($trantype == 'rent'){
                                _e('Bất động sản cho thuê', SHORT_NAME);
                            } else if($trantype == 'invest'){
                                _e('Bất động sản đầu tư', SHORT_NAME);
                            } else {
                                _e('Tin rao Bất động sản', SHORT_NAME);
                            }
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
            <?php if ( is_active_sidebar( 'sidebar_product' ) ) { dynamic_sidebar( 'sidebar_product' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
