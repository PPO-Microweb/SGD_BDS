<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta http-equiv="Cache-control" content="no-store; no-cache"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="author" content="PPO.VN" />
    <meta name="robots" content="index, follow" /> 
    <meta name="googlebot" content="index, follow" />
    <meta name="bingbot" content="index, follow" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.position" content="14.058324;108.277199" />
    <meta name="ICBM" content="14.058324, 108.277199" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php if(is_home() or is_front_page()): ?>
    <meta name="keywords" content="<?php echo get_option('keywords_meta') ?>" />
    <?php endif; ?>
    
    <link rel="publisher" href="https://plus.google.com/+PpoVnWebSoftAppsDesign"/>
    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />        
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php if (is_singular() && pings_open(get_queried_object_id())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php endif; ?>

    <script>
        var siteUrl = "<?php bloginfo('siteurl'); ?>";
        var themeUrl = "<?php bloginfo('stylesheet_directory'); ?>";
        var no_image_src = themeUrl + "/assets/images/no_image_available.jpg";
        var is_fixed_menu = <?php echo (get_option(SHORT_NAME . "_fixedMenu")) ? 'true' : 'false'; ?>;
        var is_home = <?php echo is_home() ? 'true' : 'false'; ?>;
        var show_popup = <?php echo (get_option(SHORT_NAME . "_showPopup")) ? 'true' : 'false'; ?>;
        var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
        var hotline = '<?php echo get_option(SHORT_NAME . "_hotline") ?>';
        var website = '<?php echo get_option(SHORT_NAME . "_website") ?>';
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="ajax_loading" style="display: none;z-index: 9999999" class="ajax-loading-block-window">
        <div class="loading-image"></div>
    </div>
    <!--Alert Message-->
    <div id="nNote" class="nNote" style="display: none;"></div>
    <!--END: Alert Message-->
    
    <div id="header">
        <div class="container">
            <div class="row top_header">
                <div class="col-md-5 hidden-sm hidden-xs">
                    <div class="top-info">
                        Hotline: <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>"><?php echo get_option(SHORT_NAME . "_hotline") ?></a> | 
                        Email: <a href="mailto:<?php echo get_option("info_email") ?>"><?php echo get_option("info_email") ?></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="top_link">
                        <ul>
                            <?php
                            global $current_user;
                            $current_account_level = intval(get_option(SHORT_NAME . "_user_level_default"));
                            $user_level_max = intval(get_option(SHORT_NAME . "_user_level_max"));
                            if(is_user_logged_in()){
                                $current_account_level = get_the_author_meta( 'account_level', $current_user->ID );
                            }
                            if (is_user_logged_in() and $current_account_level != $user_level_max):
                            ?>
                            <li class="upgrade">
                                <a title="Nâng cấp Tài khoản" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageUpgradeAccount")); ?>">Nâng cấp</a>
                            </li>
                            <?php endif; ?>
                            <li>
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
                                <a title="Đăng tin Bán/Cho thuê Nhà đất" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageposter")); ?>">Đăng tin</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 
                                <a title="Yêu cầu Thuê/Mua" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagesale")); ?>">Yêu cầu</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> 
                                <a title="Ký gửi nhà đất" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagesign")); ?>">Ký gửi</a>
                            </li>
                            <li class="toggle-acc-options">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <ul class="nav">
                                    <?php if (!is_user_logged_in()): ?>
                                    <li>
                                        <a title="Đăng nhập" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelogin")); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Đăng nhập</a>
                                    </li> 
                                    <li>
                                        <a title="Đăng ký" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageregister")); ?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Đăng ký</a>
                                    </li>
                                    <li>
                                        <a title="Affiliate" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageAffiliate")); ?>"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Affiliate</a>
                                    </li>
                                    <?php else: ?>
                                    <li>
                                        <a title="Quản lý tin đăng" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageManagePosts")); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Quản lý tin đăng</a>
                                    </li>
                                    <li>
                                        <a title="Tin theo dõi" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageFollowPosts")); ?>"><span class="glyphicon glyphicon-record" aria-hidden="true"></span> Tin theo dõi</a>
                                    </li>
                                    <li>
                                        <a title="Danh sách Yêu thích" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageFavorites")); ?>"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Yêu thích</a>
                                    </li>
                                    <li>
                                        <a title="Tài khoản" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageprofile")); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Tài khoản</a>
                                    </li>
                                    <?php if($current_account_level != $user_level_max): ?>
                                    <li>
                                        <a title="Nâng cấp Tài khoản" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageUpgradeAccount")); ?>"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Nâng cấp</a>
                                    </li>
                                    <?php endif; ?>
                                    <li>
                                        <a title="Đổi mật khẩu" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelostpassword")); ?>"><span class="fa fa-key" aria-hidden="true"></span> Đổi mật khẩu</a>
                                    </li>
                                    <li>
                                        <a title="Affiliate" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageAffiliate")); ?>"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Affiliate</a>
                                    </li>
                                    <li>
                                        <a title="Thoát" href="<?php echo wp_logout_url(); ?>" onclick="return confirm('Bạn có chắc chắn muốn thoát?');"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Thoát</a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="head-mid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5">
                        <div id="header_logo" itemtype="http://schema.org/Organization" itemscope="itemscope">
                            <a title="<?php bloginfo('sitename'); ?>" itemprop="url" href="<?php bloginfo('siteurl'); ?>">
                                <img alt="<?php bloginfo('sitename'); ?>" src="<?php echo get_option('sitelogo'); ?>" itemprop="logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 hidden-xs container-count">
                        <div class="wrap-count-header">
                            <p class="number-count">
                                <?php echo wp_statistics_visit('total'); ?>
                            </p>
                            <p class="text-count">
                                Lượt xem
                            </p>
                        </div>
                        <div class="wrap-count-header">
                            <p class="number-count">
                                <?php
                                    $count_user = count_users();
                                    echo $count_user['total_users'];
                                ?>
                            </p>
                            <p class="text-count">
                                Thành viên
                            </p>
                        </div>
                        <div class="wrap-count-header">
                            <p class="number-count">
                                <?php
                                    $count_posts = wp_count_posts('supplier');
                                    $published_posts = $count_posts->publish;
                                    echo $published_posts;
                                ?>
                            </p>
                            <p class="text-count">
                                Nhà cung cấp
                            </p>
                        </div>
                        <div class="wrap-count-header">
                            <p class="number-count">
                                <?php
                                    $count_posts = wp_count_posts('project');
                                    $published_posts = $count_posts->publish;
                                    echo $published_posts;
                                ?>
                            </p>
                            <p class="text-count">
                                Dự án
                            </p>
                        </div>
                        <div class="wrap-count-header">
                            <p class="number-count">
                                <?php
                                    $count_posts = wp_count_posts('product');
                                    $published_posts = $count_posts->publish;
                                    echo $published_posts;
                                ?>
                            </p>
                            <p class="text-count">
                                Bất động sản
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ppo_menu">
            <div class="container" style="position: relative">
                <a id="menu">
                    <span class="menu-mobile-icon">&nbsp;</span>
                </a>
                <?php
                wp_nav_menu(array(
                    'container' => '',
                    'theme_location' => 'primary',
                    'menu_class' => 'main_menu',
                ));
                
                if(get_option('mobilelogo')):
                ?>
                <a href="<?php bloginfo('siteurl') ?>" class="logo-mobile">
                    <img alt="<?php bloginfo('name') ?>" src="<?php echo get_option('mobilelogo') ?>" />
                </a>
                <?php endif; ?>
                <span class="toggle-segments">
                    <a href="javascript://" title="Danh sách 40 phân khúc (loại) Bất động sản"><span class="glyphicon glyphicon-th" aria-hidden="true"></span></a>
                </span>
            </div>
        </div>
    </div>
    
    <!--MENU MOBILE-->
    <section class="menu-mobile">
<!--        <div class="text-right">
            <span class="btn-close-menu"></span>
        </div>-->
        <?php
        wp_nav_menu(array(
            'container' => '',
            'theme_location' => 'mobile',
            'menu_class' => 'mnleft',
        ));
        ?> 
    </section>
