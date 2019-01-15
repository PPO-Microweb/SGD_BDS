<?php
/*
  Template Name: Profile
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header(); 

$districts = get_district(PROVINCE_ID);
$author = wp_get_current_user();
$display_name = trim($author->user_lastname . ' ' . $author->user_firstname);
if(empty($display_name)){
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

// Update user expiry date
if(!validate_user_expiry()){
    $today = date('Y/m/d');
    $expiry_date = date("Y/m/d", strtotime("$today+1 years"));
    $user_level_default = intval(get_option(SHORT_NAME . "_user_level_default"));
    update_usermeta($author->ID, 'user_expiry', $expiry_date);
    update_usermeta($author->ID, 'account_level', $user_level_default);
    update_usermeta($author->ID, 'limit_posting', get_field('limit_posting', $user_level_default));
    update_usermeta($author->ID, 'limit_postvip', get_field('limit_postvip', $user_level_default));
}
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
                    <div class="col-md-2 col-sm-3">
                        <div class="avatar">
                            <?php echo get_avatar($author->ID, 108); ?>
                            <div class="user-rating text-center">
                                <div class="ratings">
                                    <?php echo ppo_user_ratings($author->ID); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <div class="info">
                            <h1 class="name"><?php echo $display_name; ?></h1>
                            <h3 class="login">(<?php echo $author->user_login ?>)</h3>
                            <div class="description">- Bạn có thể thay ảnh đại diện tại <a href="https://en.gravatar.com/" target="_blank" rel="nofollow" style="color:blue">Gravatar</a>.</div>
                            <div class="description">- Thay đổi địa chỉ Email cần liên hệ <a href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagecontact")); ?>" target="_blank" style="color:blue">Administrator</a>.</div>
                        </div>
                        <div class="level">
                            <div class="user_expiry">Hết hạn: <?php echo date('d/m/Y', strtotime(get_the_author_meta( 'user_expiry', $author->ID ))) ?></div>
                            <span>Loại tài khoản: </span>
                            <?php
                            $current_account_level = get_the_author_meta( 'account_level', $author->ID );
                            echo '<strong style="color:'.get_field('bgcolor', $current_account_level).'">'.get_the_title($current_account_level).'</strong>';
                            if($current_account_level != intval(get_option(SHORT_NAME . "_user_level_max"))){
                                echo '<a href="'.get_page_link(get_option(SHORT_NAME . "_pageUpgradeAccount")).'" class="btn btn-primary btn-upgrade">Nâng cấp</a>';
                            }
                            ?>
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
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <form action="" method="post" class="form" id="frmChangeProfile">
                        <h3 class="user-block-title">Thông tin cá nhân</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">Tên</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo $author->user_firstname ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Họ và đệm</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $author->user_lastname ?>" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="url">Website</label>
                                    <input type="text" id="url" name="url" value="<?php echo $website; ?>" class="form-control" placeholder="http://domain.com" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Địa chỉ email</label>
                                    <input type="text" value="<?php echo $author->user_email; ?>" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="twitter">Twitter username (Không bao gồm @)</label>
                                    <input type="text" id="twitter" name="twitter" value="<?php echo $twitterURL; ?>" class="form-control" placeholder="username" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="googleplus">Google+ URL</label>
                            <input type="text" id="googleplus" name="googleplus" value="<?php echo $googlePlusURL; ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook profile URL</label>
                            <input type="text" id="facebook" name="facebook" value="<?php echo $fbURL; ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="description">Giới thiệu</label>
                            <textarea id="description" name="description" class="form-control" rows="5"><?php echo $author->description; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="workplace_address">Địa chỉ nơi làm việc</label>
                            <input type="text" id="workplace_address" name="workplace_address" value="<?php echo esc_attr(get_the_author_meta('workplace_address', $author->ID)); ?>" class="form-control" />
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="user_city">Tỉnh/Thành phố</label>
                                    <select name="user_city" id="user_city" class="form-control">
                                        <?php
                                        $cities = vn_city_list();
                                        foreach ($cities as $city) {
                                            if (esc_attr(get_the_author_meta('user_city', $author->ID)) == $city) {
                                                echo '<option value="' . $city . '" selected="selected">' . $city . '</option>';
                                            } else {
                                                echo '<option value="' . $city . '">' . $city . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="user_country">Quốc tịch</label>
                                    <select name="user_country" id="user_country" class="form-control">
                                        <?php
                                        $countries = country_list();
                                        foreach ($countries as $country) {
                                            if (esc_attr(get_the_author_meta('user_country', $author->ID)) == $country) {
                                                echo '<option value="' . $country . '" selected="selected">' . $country . '</option>';
                                            } else {
                                                echo '<option value="' . $country . '">' . $country . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="gender">Giới tính</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <?php
                                        foreach (gender_list() as $key => $value) {
                                            if (esc_attr(get_the_author_meta('gender', $author->ID)) == $key) {
                                                echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                                            } else {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="family_status">Tình trạng gia đình</label>
                                    <select name="family_status" id="family_status" class="form-control">
                                        <?php
                                        foreach (family_status() as $key => $value) {
                                            if (esc_attr(get_the_author_meta('family_status', $author->ID)) == $key) {
                                                echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                                            } else {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dob">Ngày sinh <em class="small">(Năm/tháng/ngày)</em></label>
                                    <input type="text" name="dob" id="dob" value="<?php echo esc_attr(get_the_author_meta('dob', $author->ID)) ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edu">Học vấn</label>
                                    <select name="edu" id="edu" class="form-control">
                                        <?php
                                        foreach (education_list() as $key => $value) {
                                            if (esc_attr(get_the_author_meta('edu', $author->ID)) == $key) {
                                                echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                                            } else {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_exp">Kinh nghiệm làm việc</label>
                                    <select name="user_exp" id="user_exp" class="form-control">
                                    <?php
                                    foreach (user_exp_list() as $exp => $val) {
                                        if (esc_attr(get_the_author_meta('user_exp', $author->ID)) == $exp) {
                                            echo '<option value="' . $exp . '" selected="selected">' . $val . '</option>';
                                        } else {
                                            echo '<option value="' . $exp . '">' . $val . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="user-block-title">Thị trường kinh doanh</h3>
                        <div class="mb15 italic">Bạn sẽ nhận được những thông tin bất động sản mà bạn quan tâm ở trang <a href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageFollowPosts")); ?>">Tin theo dõi</a>.</div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_segment1">Phân khúc (01)</label>
                                    <?php
                                    wp_dropdown_categories(array(
                                        'show_option_all' => '- Chọn phân khúc -',
                                        'name' => 'bds_segment1', 
                                        'taxonomy' => 'product_category', 
                                        'selected' => $bds_segment1,
                                        'hierarchical' => true,
                                        'hide_empty' => false,
                                        'value_field' => 'term_id',
                                        'class' => 'form-control',
                                        'id' => 'bds_segment1',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_location1">Địa bàn (01)</label>
                                    <select name="bds_location1" id="bds_location1" class="form-control">
                                        <option value="">- Chọn địa bàn -</option>
                                        <?php
                                        foreach ($districts as $district) {
                                            if ($bds_location1 === $district->districtid) {
                                                echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                                            } else {
                                                echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_segment2">Phân khúc (02)</label>
                                    <?php
                                    wp_dropdown_categories(array(
                                        'show_option_all' => '- Chọn phân khúc -',
                                        'name' => 'bds_segment2', 
                                        'taxonomy' => 'product_category', 
                                        'selected' => $bds_segment2,
                                        'hierarchical' => true,
                                        'hide_empty' => false,
                                        'value_field' => 'term_id',
                                        'class' => 'form-control',
                                        'id' => 'bds_segment2',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_location2">Địa bàn (02)</label>
                                    <select name="bds_location2" id="bds_location2" class="form-control">
                                        <option value="">- Chọn địa bàn -</option>
                                        <?php
                                        foreach ($districts as $district) {
                                            if ($bds_location2 === $district->districtid) {
                                                echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                                            } else {
                                                echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_segment3">Phân khúc (03)</label>
                                    <?php
                                    wp_dropdown_categories(array(
                                        'show_option_all' => '- Chọn phân khúc -',
                                        'name' => 'bds_segment3', 
                                        'taxonomy' => 'product_category', 
                                        'selected' => $bds_segment3,
                                        'hierarchical' => true,
                                        'hide_empty' => false,
                                        'value_field' => 'term_id',
                                        'class' => 'form-control',
                                        'id' => 'bds_segment3',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bds_location3">Địa bàn (03)</label>
                                    <select name="bds_location3" id="bds_location3" class="form-control">
                                        <option value="">- Chọn địa bàn -</option>
                                        <?php
                                        foreach ($districts as $district) {
                                            if ($bds_location3 === $district->districtid) {
                                                echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                                            } else {
                                                echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="button" class="btnSubmit" value="Lưu thay đổi" />
                        <input type="hidden" name="action" value="change_user_profile" />
                        <input type="hidden" name="user_id" value="<?php echo $author->ID ?>" />
                    </form>
                </div>
            </div>
        </div>
    
        <div class="cat-sidebar sidebar col-md-4 col-sm-6" style="position:inherit">
            <?php get_sidebar('user') ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
