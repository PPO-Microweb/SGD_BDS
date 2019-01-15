<?php
/*
  Template Name: Upgrade
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
    exit;
}
global $current_user;
$current_account_level = get_the_author_meta( 'account_level', $current_user->ID );
$current_limit_posting = get_the_author_meta( 'limit_posting', $current_user->ID );
$user_level_max = intval(get_option(SHORT_NAME . "_user_level_max"));
$max_limit_posting = get_field( 'limit_posting', $user_level_max );
if($current_limit_posting >= $max_limit_posting){
    wp_redirect( home_url('/profile/') );
    exit;
}
get_header(); 
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="user-levels">
        <div class="section-header">
            <h1>
                <?php _e('Bảng giá dịch vụ cho nhà môi giới', SHORT_NAME) ?>
            </h1>
            <h4>Lựa chọn gói dịch vụ phù hợp với nhu cầu của bạn</h4>
        </div>
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div class="owl-carousel">
                <?php
                $loop = new WP_Query(array(
                    'post_type' => 'user_level',
                    'showposts' => -1,
                    'post_status' => 'publish',
                    'order' => 'asc'
                ));
                while ($loop->have_posts()) : $loop->the_post();
                    $bgcolor = get_field('bgcolor');
                    $price = get_field('price');
                    $duration = get_field('duration');
                    $limit_posting = get_field('limit_posting');
                    $limit_postvip = get_field('limit_postvip');
                ?>
                    <div class="item">
                        <div class="header" style="background:<?php echo $bgcolor ?>">
                            <div class="name"><?php the_title(); ?></div>
                            <div class="price">
                                <?php if($price>0): ?>
                                <?php echo number_format($price, 0, ",", ".") ?>/<?php echo $duration ?> tháng
                                <?php else: ?>
                                Miễn phí
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="body">
                            <p style="color:red"><strong>KHO TIN ĐĂNG</strong></p>
                            <p>Giới hạn tin: <strong><?php echo $limit_posting ?></strong></p>
                            <p>Giới hạn VIP: <strong><?php echo $limit_postvip ?></strong></p>
                            <hr/>
                            <?php the_content(); ?>
                        </div>
                        <div class="footer">
                            <?php if($current_account_level == get_the_ID()): ?>
                            <button type="button" class="btn btn-lg btn-buy" disabled>Hiện tại</button>
                            <?php elseif($current_limit_posting > $limit_posting): ?>
                            <button type="button" class="btn btn-lg btn-buy" disabled>Nâng cấp</button>
                            <?php else: ?>
                            <form action="" method="post" id="frmUserLevel_<?php the_ID() ?>">
                                <button type="submit" class="btn btn-lg btn-buy">Nâng cấp</button>
                                <input type="hidden" name="level_id" value="<?php the_ID() ?>" />
                                <input type="hidden" name="action" value="upgrade_account" />
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_query();
                ?>
                </div>
            </div>
            <div class="col-xs-1"></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
