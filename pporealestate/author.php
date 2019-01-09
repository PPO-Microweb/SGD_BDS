<?php 
get_header(); 

$author = get_queried_object();
$display_name = $author->user_lastname . ' ' . $author->user_firstname;
if(empty($author->user_lastname) and empty($author->user_firstname)){
    $display_name = $author->display_name;
}
$phone = get_the_author_meta( 'phone', $author->ID );
if(empty($phone)) $phone = get_option(SHORT_NAME . "_hotline");

$website = get_the_author_meta( 'url', $author->ID );
if(empty($website)) $website = "#";

$fbURL = get_the_author_meta( 'facebook', $author->ID );
if(empty($fbURL)) $fbURL = get_option(SHORT_NAME . "_fbURL");

$googlePlusURL = get_the_author_meta( 'googleplus', $author->ID );
if(empty($googlePlusURL)) $googlePlusURL = get_option(SHORT_NAME . "_googlePlusURL");

$twitterURL = get_the_author_meta( 'twitter', $author->ID );
if(empty($twitterURL)) $twitterURL = get_option(SHORT_NAME . "_twitterURL");
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
            <div class="user-info">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="avatar">
                            <?php echo get_avatar($author->ID, 150); ?>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <div class="info">
                            <h1 class="name"><?php echo $display_name; ?></h1>
                            <div><strong>M: </strong><a href="tel:<?php echo $phone ?>" rel="nofollow"><?php echo $phone ?></a></div>
                            <div><strong>E: </strong><a href="mailto:<?php echo $author->user_email ?>" rel="nofollow"><?php echo $author->user_email ?></a></div>
                            <div class="mb10"><strong>W: </strong><a href="<?php echo $website ?>" rel="nofollow"><?php echo $website ?></a></div>
                            <div class="social_footer">
                                <ul>
                                    <li class="facebook"><a target="_self" href="<?php echo $fbURL; ?>" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
                                    <li class="gplus"><a target="_self" href="<?php echo $googlePlusURL; ?>" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="twitter"><a target="_self" href="<?php echo $twitterURL; ?>" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
<!--                                    <li class="website"><a href="<?php echo $website; ?>" target="_blank" rel="nofollow"><i class="fa fa-link"></i></a></li>
                                    <li class="email"><a href="mailto:<?php echo $author->user_email; ?>" rel="nofollow"><i class="fa fa-envelope"></i></a></li>
                                    <li class="phone"><a href="tel:<?php echo $phone; ?>" rel="nofollow"><i class="fa fa-phone"></i></a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="biographical_info">
                    <?php echo $author->description; ?>
                </div>
            </div>
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="span-title">
                            <?php single_cat_title(); ?>
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
            <?php get_sidebar('user') ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
