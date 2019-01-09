<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <div class="product-tabs">
                    <ul class="ui-tabs-nav">
                        <?php if( get_field('gallery') ) : ?>
                        <li><a href="#product-gallery" rel="nofollow">Hình ảnh</a></li>
                        <?php endif; ?>
                        <?php if( get_field('video') ) : ?>
                        <li><a href="#product-video" rel="nofollow">Video</a></li>
                        <?php endif; ?>
                        <?php if( get_field('maps') ) : ?>
                        <li><a href="#product-maps" rel="nofollow">Bản đồ</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php if( get_field('gallery') ) : ?>
                    <div id="product-gallery" class="product-gallery">
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
                    <?php if( get_field('video') ) : ?>
                    <div id="product-video" class="post-video">
                        <?php the_field('video') ?>
                    </div>
                    <?php endif; ?>
                    <?php if( get_field('maps') ) : ?>
                    <div id="product-maps" class="post-maps">
                        <?php the_field('maps') ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="short_info">
                    <h1 class="title_product"><?php the_title(); ?></h1> 
                    <span class="bold-red">Mã tin:</span> <?php the_ID(); ?>
                    <span class="bold-red" style="margin-left: 10px;">Ngày đăng: </span>
                    <?php the_time('d-m-Y'); ?>
                    <span class="bold-red" style="margin-left: 10px;">Ngày kết thúc: </span>
                    <?php echo date('d-m-Y', strtotime(get_post_meta(get_the_ID(), "end_time", true))) ?>
                    <div class="tools">
                        <span class="save-post" data-id="<?php the_ID() ?>" title="Thêm vào yêu thích"><i class="fa fa-heart"></i> Yêu thích</span>
                        <span class="compare-post" data-id="<?php the_ID() ?>" title="So sánh bất động sản"><i class="fa fa-exchange"></i> So sánh</span>
                    </div>
                </div>
                <div class="thong-so">
                    <h3 class="title_head">Thông số cơ bản</h3>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Giá:</th>
                            <td>
                                <strong style="color:red"><?php echo get_post_meta(get_the_ID(), "price", true); ?> <?php echo get_unitCurrency(get_post_meta(get_the_ID(), "currency", true));?><?php echo get_unitPrice(get_post_meta(get_the_ID(), "unitPrice", true));?></strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Diện tích:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "dt", true); ?> m2</td>
                        </tr>
                        <tr>
                            <th>Hoa hồng:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "com", true); ?></td>
                        </tr>
                        <tr>
                            <th>Hướng:</th>
                            <td>
                                <?php
                                $direction = get_post_meta(get_the_ID(), 'direction', true);
                                echo get_direction($direction);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Mặt tiền:</th>
                            <td>
                                <?php
                                $mat_tien = get_post_meta(get_the_ID(), "mat_tien", true);
                                if(!empty($mat_tien)){
                                    echo $mat_tien . ' m';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Đường vào:</th>
                            <td>
                                <?php
                                $duong_truoc_nha = get_post_meta(get_the_ID(), "duong_truoc_nha", true);
                                if(!empty($duong_truoc_nha)){
                                    echo $duong_truoc_nha . ' m';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Số tầng:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "so_tang", true) ?></td>
                        </tr>
                        <tr>
                            <th>Số phòng ngủ:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "so_phong", true) ?></td>
                        </tr>
                        <tr>
                            <th>Số toilet:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "toilet", true) ?></td>
                        </tr>
                        <tr>
                            <th>Khu vực:</th>
                            <td><?php echo get_post_meta(get_the_ID(), "vi_tri", true); ?></td>
                        </tr>
                        <tr>
                            <th>BĐS phù hợp để:</th>
                            <td>
                                <ul class="purpose-list normal">
                                <?php
                                $purposes = get_the_terms(get_the_ID(), 'product_purpose');
                                foreach($purposes as $purpose){
                                    echo '<li>- '.$purpose->name.'</li>';
                                }
                                ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Đặc điểm của BĐS:</th>
                            <td>
                                <ul class="special-list normal">
                                <?php
                                $specials = get_the_terms(get_the_ID(), 'product_special');
                                foreach($specials as $special){
                                    echo '<li>- '.$special->name.'</li>';
                                }
                                ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="description">
                    <h3 class="title_head">Mô tả chi tiết</h3>
                    <div class="main_des">
                        <?php the_content();?>
                        <?php show_share_socials(); ?>
                        <?php the_tags( '<div class="post-tags"><span class="glyphicon glyphicon-tags"></span> Tags: ', ', ', '</div>'); ?>
                    </div>
                </div>
                <div class="related_product">
                    <div class="title-pro">
                        <h3>
                            <span>Có thể bạn quan tâm</span>
                        </h3>  
                    </div>
                    <div class="carousel-products-widget product-grid-container">
                        <div class="row">
                        <?php
                            $taxonomy = 'product_category';
                            $terms = get_the_terms(get_the_ID(), $taxonomy);
                            $terms_id = array();
                            $term_id = 0;
                            foreach ($terms as $term) {
                                array_push($terms_id, $term->term_id);
                                if($term->parent == 0){
                                    $term_id = $term->term_id;
                                }
                            }
                            $loop = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 6,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'term_id',
                                        'terms' => $terms_id,
                                    )
                                ),
                                'order' => 'DESC',
                                'orderby' => array('rand', 'meta_value_num', 'post_date'),
                                'meta_key' => 'not_in_vip',
                                'post__not_in' => array(get_the_ID()),
                                'meta_query' => array(
                                    array(
                                        'key' => 'end_time',
                                        'value' => date('Y/m/d', strtotime("today")),
                                        'compare' => '>=',
                                        'type' => 'DATE'
                                    )
                                )
                            ));
                            while ($loop->have_posts()) : $loop->the_post();
                                echo '<div class="col-sm-4 col-xs-6">';
                                get_template_part('template', 'product_item2');
                                echo '</div>';
                            endwhile;
                            wp_reset_query();
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right sidebar col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <?php
            $author = get_user_by( 'ID', get_the_author_meta( 'ID' ) );
            $display_name = $author->user_lastname . ' ' . $author->user_firstname;
            if(empty($author->user_lastname) and empty($author->user_firstname)){
                $display_name = $author->display_name;
            }
            if(get_post_meta(get_the_ID(), 'contact_name', TRUE)){
                $display_name = get_post_meta(get_the_ID(), 'contact_name', TRUE);
            }
            $phone = get_post_meta(get_the_ID(), 'contact_tel', TRUE);
            if(empty($phone)) $phone = get_the_author_meta( 'phone', $author->ID );
            if(empty($phone)) $phone = get_option(SHORT_NAME . "_hotline");
            $contact_email = get_post_meta(get_the_ID(), 'contact_email', TRUE);
            if(empty($contact_email)) $contact_email = $author->user_email;
            if(empty($contact_email)) $contact_email = get_option('info_email');
            ?>
            <div class="widget widget-product-owner">
                <div class="widget-title">Được đăng bởi</div>
                <div class="widget-content">
                    <div class="avatar">
                        <a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ) ?>">
                            <?php echo get_avatar($author->ID, 150); ?>
                        </a>
                    </div>
                    <div class="name"><?php echo $display_name; ?></div>
                    <p>
                        <strong>M: </strong><?php echo $phone; ?><br/>
                        <strong>E: </strong><?php echo $contact_email; ?><br/>
                        <strong>W: </strong><?php echo get_the_author_meta( 'url', $author->ID ); ?>
                    </p>
                    <div class="user-location-active">
                        <?php
                        $bds_segment1 = get_the_author_meta( 'bds_segment1', $author->ID );
                        $bds_segment2 = get_the_author_meta( 'bds_segment2', $author->ID );
                        $bds_segment3 = get_the_author_meta( 'bds_segment3', $author->ID );
                        $bds_location1 = get_the_author_meta( 'bds_location1', $author->ID );
                        $bds_location2 = get_the_author_meta( 'bds_location2', $author->ID );
                        $bds_location3 = get_the_author_meta( 'bds_location3', $author->ID );
                        $html_output = "";
                        if(!empty($bds_segment1) and !empty($bds_location1)){
                            $term = get_term( $bds_segment1, 'product_category');
                            $location = get_district_by_id($bds_location1);
                            $html_output .=  '<div class="segment" title="'.$term->name.'">' . get_short_string($term->name, 12) . '</div>';
                            $html_output .=  '<div class="location">' . $location->name . '</div>';
                            $html_output .=  '<div class="clearfix"></div>';
                        }
                        if(!empty($bds_segment2) and !empty($bds_location2)){
                            $term = get_term( $bds_segment2, 'product_category');
                            $location = get_district_by_id($bds_location2);
                            $html_output .=  '<div class="segment" title="'.$term->name.'">' . get_short_string($term->name, 12) . '</div>';
                            $html_output .=  '<div class="location">' . $location->name . '</div>';
                            $html_output .=  '<div class="clearfix"></div>';
                        }
                        if(!empty($bds_segment3) and !empty($bds_location3)){
                            $term = get_term( $bds_segment3, 'product_category');
                            $location = get_district_by_id($bds_location3);
                            $html_output .=  '<div class="segment" title="'.$term->name.'">' . get_short_string($term->name, 12) . '</div>';
                            $html_output .=  '<div class="location">' . $location->name . '</div>';
                            $html_output .=  '<div class="clearfix"></div>';
                        }
                        echo $html_output;
                        ?>
                    </div>
                    <a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ) ?>" class="xem-them">Xem thêm</a>
                </div>
            </div>
            
            <div class="widget widget-contact-publisher">
                <div class="widget-title">Liên hệ người đăng tin</div>
                <div class="widget-content">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" name="name" value="" placeholder="Họ và tên" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="" placeholder="Địa chỉ Email" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <input type="tel" name="tel" value="" placeholder="Số điện thoại" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <textarea rows="5" class="form-control" name="message">Tôi đã xem thông tin về “<?php the_title() ?>” trên website. Tôi muốn bạn cung cấp thêm thông tin và tư vấn cụ thể hơn. Cảm ơn bạn!</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi liên hệ" class="btn btn-lg btn-primary" />
                            <input type="hidden" name="action" value="send_contact_publisher" />
                            <input type="hidden" name="pid" value="<?php the_ID() ?>" />
                            <input type="hidden" name="uid" value="<?php echo get_the_author_meta( 'ID' ) ?>" />
                        </div>
                    </form>
                </div>
            </div>
            
            <?php
            $productProjects = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 1,
                'p' => intval(get_post_meta(get_the_ID(), 'project', true)),
            ));
            if($productProjects->found_posts > 0){
            ?>
            <div class="widget widget-product-project">
                <div class="widget-title">Thuộc dự án</div>
                <div class="widget-content carousel-products-widget product-grid-container">
                    <?php
                    while ($productProjects->have_posts()) : $productProjects->the_post();
                        get_template_part('template', 'project_item2');
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
            <?php } ?>
            
            <?php if ( is_active_sidebar( 'sidebar_product' ) ) { dynamic_sidebar( 'sidebar_product' ); } ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>