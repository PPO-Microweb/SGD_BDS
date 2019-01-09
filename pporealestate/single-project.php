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
        <div class="left col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <div class="short_info">
                    <h1 class="title_product"><?php the_title(); ?></h1> 
                    <span class="bold-red">Khu vực: </span>
                    <?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?><br/>
                    <span class="bold-red">Trạng thái: </span>
                    <?php echo project_status()[get_post_meta(get_the_ID(), "status", true)]; ?>
                    <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                    <div class="project-meta">
                        <div class="price">Giá <?php echo get_post_meta(get_the_ID(), "project_price", true); ?></div>
                        <div class="area">DT <?php echo get_post_meta(get_the_ID(), "project_area", true); ?></div>
                    </div>
                </div>
                <?php if( get_field('gallery') ) : ?>
                <div class="product-gallery">
                    <div class="owl-carousel">
                        <?php
                        $gallery = get_field('gallery');
                        foreach ($gallery as $_gallery) :
                        ?>
                        <img src="<?php echo $_gallery['url']; ?>" alt="<?php echo $_gallery['title']; ?>" />
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="description">
                    <?php if( get_field('video') ) : ?>
                    <div class="post-video">
                        <?php the_field('video') ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="title_head">Mô tả chi tiết</h3>
                    <div class="main_des">
                        <?php the_content();?>
                        
                        <?php if( get_field('maps') ) : ?>
                        <div class="post-maps">
                            <?php the_field('maps') ?>
                        </div>
                        <?php endif; ?>
                        <?php show_share_socials(); ?>
                        <?php the_tags( '<div class="post-tags"><span class="glyphicon glyphicon-tags"></span> Tags: ', ', ', '</div>'); ?>
                    </div>
                    <?php
                    $products = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 12,
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'project',
                                'value' => get_the_ID(),
                            ),
                            array(
                                'key' => 'end_time',
                                'value' => date('Y/m/d', strtotime("today")),
                                'compare' => '>=',
                                'type' => 'DATE'
                            )
                        ),
                    ));
                    if($products->post_count > 0):
                    ?>
                    <div class="related_product mb30">
                        <div class="title-pro">
                            <h3>
                                <span>Bất động sản thuộc <?php the_title(); ?></span>
                            </h3>
                        </div>
                        <div class="carousel-products-widget product-grid-container">
                            <div class="row">
                            <?php
                            while ($products->have_posts()) : $products->the_post();
                                echo '<div class="col-sm-4 col-xs-6">';
                                get_template_part('template', 'product_item2');
                                echo '</div>';
                            endwhile;
                            wp_reset_query();
                            ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="right sidebar col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <?php
            $supplier_id = get_post_meta(get_the_ID(), "supplier", true);
            if($supplier_id):
            ?>
            <div class="widget widget-product-owner">
                <div class="widget-title">Chủ đầu tư</div>
                <div class="widget-content">
                    <div class="avatar">
                        <a href="<?php echo get_permalink($supplier_id) ?>">
                            <img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url($supplier_id, 'full'); ?>" />
                        </a>
                    </div>
                    <div class="name"><?php echo get_the_title($supplier_id); ?></div>
                    <?php if(function_exists('the_ratings_results')) { echo the_ratings_results($supplier_id); } ?>
                    <a href="<?php echo get_permalink($supplier_id) ?>" class="xem-them">Xem thêm</a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php
            $projectsNcc = new WP_Query(array(
                'post_type' => 'project',
                'showposts' => 5,
                'post__not_in' => array(get_the_ID()),
                'post_status' => 'publish',
                'meta_query' => array(
//                    'relation' => 'AND',
                    array(
                        'key'     => 'supplier',
                        'value'   => $supplier_id,
                        'compare' => '=',
                    ),
//                    array(
//                        'key'     => 'status',
//                        'value'   => array( 'soom', 'open' ),
//                        'compare' => 'IN',
//                    ),
                ),
            ));
            if($projectsNcc->found_posts > 0):
            ?>
            <div class="widget project-list-widget">
                <div class="widget-title">Dự án Cùng chủ đầu tư</div>
                <div class="widget-content">
                    <?php
                    while ($projectsNcc->have_posts()) : $projectsNcc->the_post();
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        $no_image_url = get_template_directory_uri() . "/assets/images/no_image.png";
                        $khu_vuc = get_post_meta(get_the_ID(), "khu_vuc", true);
                    ?>
                    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                        <div class="col-xs-3 pdl0 pdr0">
                            <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark" 
                               onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');">
                                <img src="<?php echo $thumbnail_url ?>" alt="<?php the_title(); ?>" itemprop="image" 
                                     onError="this.src='<?php echo $no_image_url ?>'" />
                            </a>
                        </div>
                        <div class="col-xs-9">
                            <h3 class="entry-title" itemprop="name">
                                <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url" 
                                   onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');"><?php the_title(); ?></a>
                            </h3>
                            <p class="location"><?php echo $khu_vuc ?></p>
                        </div>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php
            $projectsLoc = new WP_Query(array(
                'post_type' => 'project',
                'showposts' => 5,
                'post__not_in' => array(get_the_ID()),
                'post_status' => 'publish',
                'meta_query' => array(
//                    'relation' => 'AND',
                    array(
                        'key'     => 'khu_vuc',
                        'value'   => get_post_meta(get_the_ID(), "khu_vuc", true),
                        'compare' => '=',
                    ),
//                    array(
//                        'key'     => 'status',
//                        'value'   => array( 'soom', 'open' ),
//                        'compare' => 'IN',
//                    ),
                ),
            ));
            if($projectsLoc->found_posts > 0):
            ?>
            <div class="widget project-list-widget">
                <div class="widget-title">Dự án Cùng khu vực</div>
                <div class="widget-content">
                    <?php
                    while ($projectsLoc->have_posts()) : $projectsLoc->the_post();
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        $no_image_url = get_template_directory_uri() . "/assets/images/no_image.png";
                        $khu_vuc = get_post_meta(get_the_ID(), "khu_vuc", true);
                    ?>
                    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                        <div class="col-xs-3 pdl0 pdr0">
                            <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark" 
                               onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');">
                                <img src="<?php echo $thumbnail_url ?>" alt="<?php the_title(); ?>" itemprop="image" 
                                     onError="this.src='<?php echo $no_image_url ?>'" />
                            </a>
                        </div>
                        <div class="col-xs-9">
                            <h3 class="entry-title" itemprop="name">
                                <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url" 
                                   onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');"><?php the_title(); ?></a>
                            </h3>
                            <p class="location"><?php echo $khu_vuc ?></p>
                        </div>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php
            $date_format = get_option( 'date_format' );
            $time_format = get_option( 'time_format' );
            $project_posts = new WP_Query(array(
                'post_type' => 'post',
                'showposts' => 5,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key'     => 'project',
                        'value'   => get_the_ID(),
                        'compare' => '=',
                    ),
                ),
            ));
            if($project_posts->found_posts > 0):
            ?>
            <div class="widget cat-posts-list-widget">
                <div class="widget-title">Bản tin về dự án</div>
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
                            <div class="entry-meta hide hidden">
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
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>