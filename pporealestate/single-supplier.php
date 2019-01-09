<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <h1 class="title_product"><?php the_title(); ?></h1>
                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                <div class="description mt15">
                    <div class="main_des pdb30">
                        <?php the_content();?>
                    </div>
                    <?php endwhile; ?>
                    <div class="related_product">
                        <div class="title-pro">
                            <h3>
                                <span>Các dự án thuộc <?php the_title(); ?></span>
                            </h3>  
                        </div>
                        <div class="carousel-products-widget product-grid-container">
                            <div class="row">
                            <?php
                            $loop = new WP_Query(array(
                                'post_type' => 'project',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => 'supplier',
                                        'value' => get_the_ID(),
                                    ),
                                ),
                            ));
                            while ($loop->have_posts()) : $loop->the_post();
                                echo '<div class="col-xs-6">';
                                get_template_part('template', 'project_item2');
                                echo '</div>';
                            endwhile;
                            wp_reset_query();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_template_part('template/widget-district-list'); ?>
            <?php get_template_part('template', 'sidebarsearch'); ?>
            <?php
            $date_format = get_option( 'date_format' );
            $time_format = get_option( 'time_format' );
            $project_posts = new WP_Query(array(
                'post_type' => 'post',
                'showposts' => 5,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key'     => 'supplier',
                        'value'   => get_the_ID(),
                        'compare' => '=',
                    ),
                ),
            ));
            if($project_posts->found_posts > 0):
            ?>
            <div class="widget cat-posts-list-widget">
                <div class="widget-title">Bản tin về nhà cung cấp</div>
                <div class="widget-content">
                    <?php while ($project_posts->have_posts()) : $project_posts->the_post(); ?>
                    <div class="item">
                        <div class="thumbnail col-sm-3">
                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                            <div class="entry-meta">
                                <span><?php the_time($time_format); ?></span> | 
                                <span itemprop="datePublished"><?php echo date($date_format, strtotime($post->post_date)); //the_date($date_format); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>