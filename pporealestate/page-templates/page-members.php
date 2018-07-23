<?php 
/*
  Template Name: Thành viên
 */
get_header(); 
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="products">
        <div class="section-header">
            <div class="list-header">
                <h1 class="span-title">Thành viên</h1>
            </div>
        </div>
        <div class="user_list">
            <div class="row">
                <?php 
                $number = 16;
                $count_users = count_users();
                $total_users = $count_users['avail_roles']['contributor'];
                $paged = get_query_var('paged');
                $args = array(
                    'role'         => 'contributor',
                    'orderby'      => 'post_count',
                    'order'        => 'DESC',
                    'number'       => $number,
                    'fields'       => 'all',
                    'offset'       => $paged ? ($paged - 1) * $number : 0,
                );
                $users = get_users( $args );
                foreach($users as $user):
                    $permalink = get_author_posts_url( $user->ID );
                    $display_name = $user->user_lastname . ' ' . $user->user_firstname;
                    if(empty($display_name)){
                        $display_name = $user->display_name;
                    }
                    $phone = get_the_author_meta( 'phone', $user->ID );
                    if(empty($phone)) $phone = __('Đang cập nhật', SHORT_NAME);
                    $website = get_the_author_meta( 'url', $user->ID );
                    if(empty($website)) $website = __('Đang cập nhật', SHORT_NAME);
                    $md5 = md5($user->user_email);
                    $avatar = "<img alt=\"{$display_name}\" src=\"http://2.gravatar.com/avatar/{$md5}?s=160&amp;d=mm&amp;r=g\" 
                                srcset=\"http://2.gravatar.com/avatar/{$md5}?s=192&amp;d=mm&amp;r=g 2x\" itemprop=\"image\" />";
                    if(!validate_gravatar($user->user_email)){
                        $first_char = mb_substr($display_name, 0, 2);
                        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                        $color = $rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                        $avatar = '<span class="avatar-bg" style="background:#'.$color.'"><span class="avatar-first-char">'. strtoupper($first_char).'</span></span>';
                    }
                    echo <<<HTML
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="item" itemscope="" itemtype="http://schema.org/Person">
                            <a class="avatar" href="{$permalink}" onclick="ga('send', 'event', 'Thành viên', 'Xem thành viên', '{$display_name}');">
                                {$avatar}
                            </a>
                            <h3 itemprop="name">{$display_name}</h3>
                            <p><strong>M: </strong>{$phone}</p>
                            <p><strong>E: </strong>{$user->user_email}</p>
                            <p><strong>W: </strong>{$website}</p>
                            <a href="{$permalink}" class="xem-them">Xem thêm</a>
                        </div>
                    </div>
HTML;
                endforeach;
                ?>
            </div>
            <div class="paging">
                <?php
                // Pagination
                if ($total_users > $number) {
                    $pl_args = array(
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'total' => ceil($total_users / $number),
                        'current' => max(1, $paged),
                    );

                    // for ".../page/n"
                    if ($GLOBALS['wp_rewrite']->using_permalinks())
                        $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)) . 'page/%#%/', 'paged');

                    echo paginate_links($pl_args);
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
