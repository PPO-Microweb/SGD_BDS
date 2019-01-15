<?php

/**
 * Get category childrens
 */
function get_category_childrens() {
    $term_id = getRequest('term_id');
    $html = "";
    $childrens = get_categories(array(
        'hide_empty' => 0, 
        'post_type' => 'product', 
        'taxonomy' => 'product_category', 
        'parent' => $term_id
    ));
    foreach ($childrens as $child) :
        $html .= "<option value=\"{$child->term_id}\">{$child->name}</option>";
    endforeach;
    Response($html);
    exit;
}

/* ----------------------------------------------------------------------------------- */
# Push product to SGD
/* ----------------------------------------------------------------------------------- */
function api_push_product() {
    $api_url = getRequest('url');
    $post_id = intval(getRequest('id'));
    if($api_url == 'http://www.batdongsan.vn/api/v1/realestatepost'){
        push_to_batdongsan_vn($api_url, $post_id);
    } else {
        $product = get_post($post_id);
//        $pushed = get_post_meta($post_id, 'pushed', true);
//        if($product and $pushed != 'yes'){
        if($product){
            $loai_tin = null;
            $category = null;
            $taxonomy = 'product_category';
            $terms = get_the_terms($post_id, $taxonomy);
            foreach ($terms as $term) {
                if($term->parent == 0){
                    $loai_tin = get_term( $term, $taxonomy );
                } else {
                    $category = get_term( $term, $taxonomy );
                }
            }
            $purpose_cat = array();
            $purposes = get_the_terms($post_id, 'product_purpose');
            foreach ($purposes as $purpose) {
                $purpose_cat[] = $purpose->term_id;
            }
            $product_price = array();
            $prices = get_the_terms($post_id, 'product_price');
            foreach ($prices as $price) {
                $product_price[] = $price->term_id;
            }
            $product_acreage = array();
            $acreages = get_the_terms($post_id, 'product_acreage');
            foreach ($acreages as $acreage) {
                $product_acreage[] = $acreage->term_id;
            }
            $special_cat = array();
            $specials = get_the_terms($post_id, 'product_special');
            foreach ($specials as $special) {
                $special_cat[] = $special->term_id;
            }

            $gallery = get_post_meta($post_id, 'gallery', true);
            $_gallery = array();
            if(is_array($gallery) and !empty($gallery)){
                foreach ($gallery as $__gallery) {
                    $_gallery[] = wp_get_attachment_url( $__gallery );
                }
            }

            $args = array(
                'loai_tin' => $loai_tin->name,
                'category' => $category->name,
                'purpose_cat' => $purpose_cat,
                'product_price' => $product_price,
                'product_acreage' => $product_acreage,
                'special_cat' => $special_cat,
                'post_title' => $product->post_title,
                'post_content' => $product->post_content,
                'city' => get_post_meta($post_id, 'city', true),
                'district' => get_post_meta($post_id, 'district', true),
                'ward' => get_post_meta($post_id, 'ward', true),
                'street' => get_post_meta($post_id, 'street', true),
                'trantype' => get_post_meta($post_id, 'trantype', true),
                'price' => get_post_meta($post_id, 'price', true),
                'currency' => get_post_meta($post_id, 'currency', true),
                'unitPrice' => get_post_meta($post_id, 'unitPrice', true),
                'com' => get_post_meta($post_id, 'com', true),
                'area' => get_post_meta($post_id, 'area', true),
                'vi_tri' => get_post_meta($post_id, 'vi_tri', true),
                'mat_tien' => get_post_meta($post_id, 'mat_tien', true),
                'duong_truoc_nha' => get_post_meta($post_id, 'duong_truoc_nha', true),
                'direction' => get_post_meta($post_id, 'direction', true),
                'so_tang' => get_post_meta($post_id, 'so_tang', true),
                'so_phong' => get_post_meta($post_id, 'so_phong', true),
                'toilet' => get_post_meta($post_id, 'toilet', true),
                'post_video' => get_post_meta($post_id, 'video', true),
                'post_maps' => get_post_meta($post_id, 'maps', true),
                'object_poster' => get_post_meta($post_id, 'object_poster', true),
                'product_permission' => get_post_meta($post_id, 'product_permission', true),
                'start_time' => get_post_meta($post_id, 'start_time', true),
                'end_time' => get_post_meta($post_id, 'end_time', true),
                'contact_name' => get_post_meta($post_id, 'contact_name', true),
                'contact_tel' => get_post_meta($post_id, 'contact_tel', true),
                'contact_email' => get_post_meta($post_id, 'contact_email', true),
                'thumbnail' => get_the_post_thumbnail_url($post_id, 'full'),
                'gallery' => $_gallery,
            );
            $data = http_build_query($args);
            $ch = curl_init($api_url . "/post_product");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'PPO/API');
            $returnValue = curl_exec($ch);
            curl_close($ch);

            echo $returnValue;
            $response = json_decode($returnValue);
//            if($response->status == 'success'){
//                update_post_meta($post_id, 'pushed', 'yes');
//            }
        } else {
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Không hợp lệ!',
            )));
        }
    }
    exit();
}

/**
 * 
 */
function push_to_batdongsan_vn($api_url, $post_id){
    Response(json_encode(array(
        'status' => 'error',
        'message' => 'Tính năng này chưa hoạt động!',
    )));
    /*$product = get_post($post_id);
    if($product){
        $loai_tin = "";
        $category = "";
        $taxonomy = 'product_category';
        $terms = get_the_terms($post_id, $taxonomy);
        foreach ($terms as $term) {
            if($term->parent == 0){
                $loai_tin = $term->name;
            } else {
                $category = $term->name;
            }
        }
//        $purpose_cat = array();
//        $purposes = get_the_terms($post_id, 'product_purpose');
//        foreach ($purposes as $purpose) {
//            $purpose_cat[] = $purpose->term_id;
//        }
//        $product_price = array();
//        $prices = get_the_terms($post_id, 'product_price');
//        foreach ($prices as $price) {
//            $product_price[] = $price->term_id;
//        }
//        $product_acreage = array();
//        $acreages = get_the_terms($post_id, 'product_acreage');
//        foreach ($acreages as $acreage) {
//            $product_acreage[] = $acreage->term_id;
//        }
//        $special_cat = array();
//        $specials = get_the_terms($post_id, 'product_special');
//        foreach ($specials as $special) {
//            $special_cat[] = $special->term_id;
//        }

        $gallery = get_post_meta($post_id, 'gallery', true);
        $_gallery = array();
        if(is_array($gallery) and !empty($gallery)){
            foreach ($gallery as $__gallery) {
                $_gallery[] = wp_get_attachment_url( $__gallery );
            }
        }
        
        $city = get_post_meta($post_id, 'city', true);
        $district = get_post_meta($post_id, 'district', true);
        $wardID = get_post_meta($post_id, 'ward', true);
        $content = do_shortcode($product->post_content);

        $body = array(
            'trantype' => $loai_tin,
            'category' => $category,
//            'purpose_cat' => $purpose_cat,
//            'product_price' => $product_price,
//            'product_acreage' => $product_acreage,
//            'special_cat' => $special_cat,
            'city' => get_province_by_id($city)->name,
            'district' => get_district_by_id($district)->name,
            'wards' => get_wards_by_id($wardID)->name,
            'street' => get_post_meta($post_id, 'street', true),
            'title' => $product->post_title,
            'brief' => get_short_content($content, 300),
            'content' => $content,
            'address' => get_post_meta($post_id, 'vi_tri', true),
            'price' => get_post_meta($post_id, 'price', true),
//            'currency' => get_post_meta($post_id, 'currency', true),
            'priceUnit' => get_post_meta($post_id, 'unitPrice', true),
//            'com' => get_post_meta($post_id, 'com', true),
            'area' => get_post_meta($post_id, 'area', true),
            'video' => getYoutubeID(get_post_meta($post_id, 'video', true)),
            'createTime' => date("Y-m-d H:i:s"),
            'beginTime' => date("Y-m-d H:i:s", strtotime(get_post_meta($post_id, 'start_time', true))),
            'endTime' => date("Y-m-d H:i:s", strtotime(get_post_meta($post_id, 'end_time', true))),
//            'mat_tien' => get_post_meta($post_id, 'mat_tien', true),
//            'duong_truoc_nha' => get_post_meta($post_id, 'duong_truoc_nha', true),
//            'direction' => get_post_meta($post_id, 'direction', true),
//            'so_tang' => get_post_meta($post_id, 'so_tang', true),
//            'so_phong' => get_post_meta($post_id, 'so_phong', true),
//            'toilet' => get_post_meta($post_id, 'toilet', true),
//            'post_maps' => get_post_meta($post_id, 'maps', true),
//            'object_poster' => get_post_meta($post_id, 'object_poster', true),
//            'product_permission' => get_post_meta($post_id, 'product_permission', true),
            'contactName' => get_post_meta($post_id, 'contact_name', true),
            'contactEmail' => get_post_meta($post_id, 'contact_email', true),
            'contactPhone' => get_post_meta($post_id, 'contact_tel', true),
            'crawlerLink' => get_permalink($post_id),
            'crawlerSource' => get_bloginfo('siteurl'),
            'image' => get_the_post_thumbnail_url($post_id, 'full'),
            'galleries' => $_gallery,
            'longitude' => "",
            'latitude' => "",
            'username' => 'test',
        );
        $args = array(
            'username' => 'test',
            'apikey' => '01b953fe-8ede-415d-904e-8248b8302d93',
            'body' => json_encode($body),
        );
        $data = http_build_query($args);;
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PPO/API');
        $returnValue = curl_exec($ch);
        curl_close($ch);
        
        $response = json_decode($returnValue);
        if($response->status == true){
            Response(json_encode(array(
                'status' => 'success',
                'message' => 'Đăng tin thành công',
            )));
        } else {
            Response(json_encode(array(
                'status' => 'error',
                'message' => $returnValue,
            )));
        }
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Không hợp lệ!',
        )));
    }*/
}

//THANH PHO - QUAN HUYEN - PHUONG XA

function get_ddlcity() {
    $data = list_city();
    foreach ($data as $tp) {
        $opt .= '<option value="' . $tp->CityId . '">' . $tp->CityName . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

function get_ddldistrict() {
    $city_ID = getRequest('city_id');
    $data = get_district($city_ID);
    $opt = "";
    foreach ($data as $d) {
        $opt .='<option value="' . $d->districtid . '">' . $d->name . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

function get_ddlward() {
    $district_ID = getRequest('district_id');
    $data = get_ward($district_ID);
    $opt = "";
    foreach ($data as $d) {
        $opt .='<option value="' . $d->wardid . '">' . $d->name . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

/**
 * Change user profile
 */
function change_user_profile(){
    $author = wp_get_current_user();
    $user_id = getRequest('user_id');
    $first_name = getRequest('first_name');
    $last_name = getRequest('last_name');
    $phone = getRequest('phone');
    $url = getRequest('url');
    $googleplus = getRequest('googleplus');
    $twitter = getRequest('twitter');
    $facebook = getRequest('facebook');
    $description = getRequest('description');
    $workplace_address = getRequest('workplace_address');
    $gender = getRequest('gender');
    $family_status = getRequest('family_status');
    $user_city = getRequest('user_city');
    $user_country = getRequest('user_country');
    $dob = getRequest('dob');
    $edu = getRequest('edu');
    $user_exp = getRequest('user_exp');
    $bds_segment1 = getRequest('bds_segment1');
    $bds_segment2 = getRequest('bds_segment2');
    $bds_segment3 = getRequest('bds_segment3');
    $bds_location1 = getRequest('bds_location1');
    $bds_location2 = getRequest('bds_location2');
    $bds_location3 = getRequest('bds_location3');
    
    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Phiên làm việc đã hết hạn, bạn cần đăng nhập lại để thực hiện tác vụ này.', SHORT_NAME),
        )));
    } else if($user_id != $author->ID){
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Xảy ra lỗi, vui lòng thử lại.', SHORT_NAME),
        )));
    } else if(!empty($phone) and ! is_valid_phone_number($phone)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Vui lòng nhập một số điện thoại hợp lệ.', SHORT_NAME),
        )));
    } else {
        $user_fields = array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_url' => $url,
//            'googleplus' => $googleplus,
//            'twitter' => $twitter,
//            'facebook' => $facebook,
            'description' => $description,
        );

        wp_update_user($user_fields);
        update_usermeta( $user_id, 'phone', $phone );
        update_usermeta( $user_id, 'googleplus', $googleplus );
        update_usermeta( $user_id, 'twitter', $twitter );
        update_usermeta( $user_id, 'facebook', $facebook );
        update_usermeta( $user_id, 'workplace_address', $workplace_address );
        update_usermeta( $user_id, 'gender', $gender );
        update_usermeta( $user_id, 'family_status', $family_status );
        update_usermeta( $user_id, 'user_city', $user_city );
        update_usermeta( $user_id, 'user_country', $user_country );
        update_usermeta( $user_id, 'dob', $dob );
        update_usermeta( $user_id, 'edu', $edu );
        update_usermeta( $user_id, 'user_exp', $user_exp );
        update_usermeta( $user_id, 'bds_segment1', $bds_segment1 );
        update_usermeta( $user_id, 'bds_segment2', $bds_segment2 );
        update_usermeta( $user_id, 'bds_segment3', $bds_segment3 );
        update_usermeta( $user_id, 'bds_location1', $bds_location1 );
        update_usermeta( $user_id, 'bds_location2', $bds_location2 );
        update_usermeta( $user_id, 'bds_location3', $bds_location3 );

        Response(json_encode(array(
            'status' => 'success',
            'message' => __('Lưu thay đổi thành công.', SHORT_NAME),
        )));
    }
    
    exit;
}

/**
 * Save post to Favorites
 */
function add_to_favorites(){
    global $wpdb;
    $favorites = $wpdb->prefix . 'favorites';
    $user_id = 0;
    $post_id = getRequest('post_id');
    $msg = "";
    
    if(!is_user_logged_in()){
        $msg = __('Bạn cần đăng nhập mới sử dụng được tính năng này!', SHORT_NAME);
    } else if($post_id <= 0) {
        $msg = __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME);
    } else {
        global $current_user;
        get_currentuserinfo();
        $user_id = $current_user->ID;
    }
    
    if(empty($msg)){
        $result = $wpdb->get_row($wpdb->prepare( "SELECT ID FROM $favorites WHERE user_id=%d AND post_id=%d", $user_id, $post_id ));
        if($result){
            Response(json_encode(array(
                'status' => 'success',
                'message' => __('Đã thêm vào danh sách yêu thích của bạn!'),
            )));
        } else {
            $result = $wpdb->insert($favorites, array(
                    'user_id' => $user_id,
                    'post_id' => $post_id
                ), array(
                    '%d',
                    '%d'
                )
            );
            if(!$result){
                Response(json_encode(array(
                    'status' => 'error',
                    'message' => __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME),
                )));
            } else {
                Response(json_encode(array(
                    'status' => 'success',
                    'message' => __('Đã thêm vào danh sách yêu thích của bạn!'),
                )));
            }
        }
        
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => $msg,
        )));
    }
    
    exit;
}

/**
 * Remove post to Favorites
 */
function remove_from_favorites(){
    global $wpdb;
    $favorites = $wpdb->prefix . 'favorites';
    $user_id = 0;
    $post_id = getRequest('post_id');
    $msg = "";
    
    if(!is_user_logged_in()){
        $msg = __('Bạn cần đăng nhập lại mới sử dụng được tính năng này!', SHORT_NAME);
    } else if($post_id <= 0) {
        $msg = __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME);
    } else {
        global $current_user;
        get_currentuserinfo();
        $user_id = $current_user->ID;
    }
    
    if(empty($msg)){
        $result = $wpdb->delete($favorites, array(
                'user_id' => $user_id,
                'post_id' => $post_id
            ), array(
                '%d',
                '%d'
            )
        );
        if(!$result){
            Response(json_encode(array(
                'status' => 'error',
                'message' => __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME),
            )));
        } else {
            Response(json_encode(array(
                'status' => 'success',
                'message' => __('Đã xóa một mục khỏi danh sách yêu thích của bạn!'),
            )));
        }
        
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => $msg,
        )));
    }
    
    exit;
}

/**
 * Add post to compare
 */
function add_to_compare(){
    $post_id = getRequest('post_id');
    if(isset($_SESSION['compare']) and !empty($_SESSION['compare'])){
        $compare = $_SESSION['compare'];
        if(!in_array($post_id, $compare)){
            array_push($compare, $post_id);
            $_SESSION['compare'] = $compare;
        }
    }else{
        $compare = array();
        array_push($compare, $post_id);
        $_SESSION['compare'] = $compare;
    }

    $compare = $_SESSION['compare'];
    if(count($compare) > 0){
        Response(json_encode(array(
            'redirect_url' => get_page_link(get_option(SHORT_NAME . "_pageCompare")),
            'message' => "",
        )));
    } else {
        Response(json_encode(array(
            'redirect_url' => get_page_link(get_option(SHORT_NAME . "_pageCompare")),
            'message' => __('Đã thêm vào mục so sánh. Bạn hãy chọn thêm một bất động sản khác để tiến hành so sánh.'),
        )));
    }
    
    exit;
}

/**
 * Liên hệ người đăng tin BĐS
 */
function send_contact_publisher(){
    $errMsg = "";
    $name = getRequest('name');
    $email = getRequest('email');
    $tel = getRequest('tel');
    $message = getRequest('message');
    $pid = getRequest('pid');
    $uid = getRequest('uid');
    $author = get_user_by( 'ID', $uid );
    $contact_email = get_post_meta($pid, 'contact_email', TRUE);
    if(empty($contact_email) and $author) $contact_email = $author->user_email;
    if(empty($contact_email)) $contact_email = get_option('info_email');
    $phone = get_post_meta($pid, 'contact_tel', TRUE);
    if(empty($phone) and $author) $phone = get_the_author_meta( 'phone', $author->ID );
    if(empty($phone)) $phone = get_option(SHORT_NAME . "_hotline");
    
    if(!is_valid_email($email)){
        $errMsg = "Vui lòng nhập địa chỉ email hợp lệ!";
    }
    if(!empty($errMsg)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => $errMsg,
        )));
    } else {
        $subject = "Liên hệ tư vấn thuê/mua/đầu tư Bất động sản";
        $body = <<<HTML
<p><strong>Họ và tên: </strong>{$name}</p>
<p><strong>Email: </strong>{$email}</p>
<p><strong>Số điện thoại: </strong>{$tel}</p>
<div><strong>Nội dung: </strong>{$message}</div>
HTML;

        $headers = array(
            'From: ' . $name . ' <' . $email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
        );

        add_filter('wp_mail_content_type', 'set_html_content_type');
        $result = wp_mail($contact_email, $subject, $body, $headers);

        // reset content-type to avoid conflicts
        remove_filter('wp_mail_content_type', 'set_html_content_type');
        
        global $wpdb;
        $tblCustomers = $wpdb->prefix . 'customers';
        $customer = $wpdb->get_row( "SELECT * FROM {$tblCustomers} WHERE phone='{$tel}' LIMIT 1" );
        if(!$customer){
            $result = $wpdb->insert( $tblCustomers, array(
                'fullname' => $name,
                'phone' => $tel,
                'email' => $email,
                'message' => $message,
                'updated_date' => date('Y-m-d H:i:s'),
            ), array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ) );
        }
        
        if($result){
            Response(json_encode(array(
                'status' => 'success',
                'message' => "Gửi thành công!",
            )));
        } else {
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Gửi thất bại, vui lòng liên lạc ' . $phone . ' để được trợ giúp!',
            )));
        }
    }
    exit;
}

function ppo_delete_post(){
    $post_id = intval(getRequest('post_id'));
    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Bạn chưa đăng nhập vào tài khoản!',
            'redirect_url' => home_url('/login/'),
        )));
    } else if(!get_post($post_id)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
        )));
    } else {
        $result = wp_delete_post( $post_id );
        if(!$result){
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
            )));
        } else {
            Response(json_encode(array(
                'status' => 'success',
                'message' => 'Đã xóa bài viết thành công!',
            )));
        }
    }
    exit;
}

function ppo_upvip_post(){
    $post_id = intval(getRequest('post_id'));
    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Bạn chưa đăng nhập vào tài khoản!',
            'redirect_url' => home_url('/login/'),
        )));
    } else if(!get_post($post_id)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
        )));
    } else if(!validate_user_limit_postvip()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Bạn đã đế giới hạn số tin VIP trong tài khoản. Hãy nâng cấp tài khoản để hưởng nhiều ưu đãi hơn!',
        )));
    } else {
        $result = update_post_meta( $post_id, 'not_in_vip', '1' );
        if(!$result){
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
            )));
        } else {
            Response(json_encode(array(
                'status' => 'success',
                'message' => 'Đã nâng VIP bài viết thành công!',
            )));
        }
    }
    exit;
}

function ppo_downvip_post(){
    $post_id = intval(getRequest('post_id'));
    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Bạn chưa đăng nhập vào tài khoản!',
            'redirect_url' => home_url('/login/'),
        )));
    } else if(!get_post($post_id)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
        )));
    } else {
        $result = update_post_meta( $post_id, 'not_in_vip', '0' );
        if(!$result){
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
            )));
        } else {
            Response(json_encode(array(
                'status' => 'success',
                'message' => 'Đã xóa VIP cho bài viết thành công!',
            )));
        }
    }
    exit;
}

function upgrade_account(){
    $level_id = intval(getRequest('level_id'));
    $price = get_field('price', $level_id);

    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Bạn chưa đăng nhập vào tài khoản!',
            'redirect_url' => home_url('/login/'),
        )));
    } elseif(empty ($level_id) or $level_id <= 0) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
        )));
    } else {
        global $wpdb, $nl_checkout, $current_user;
        
        $limit_posting = get_field('limit_posting', $level_id);
        $current_limit_posting = get_the_author_meta( 'limit_posting', $current_user->ID );
        $tblOrders = $wpdb->prefix . 'orders';
        if($current_limit_posting >= $limit_posting){
            Response(json_encode(array(
                'status' => 'error',
                'message' => 'Bạn không thể hạ cấp, nếu bạn cho rằng đây là lỗi hãy liên hệ với chúng tôi để được trợ giúp!',
            )));
        } else {
            $order_code = 0;
            $order = $wpdb->get_row( "SELECT * FROM {$tblOrders} WHERE user_id={$current_user->ID} AND level_id={$level_id} LIMIT 1" );
            if($order and $order->payment_status == 0){
                $order_code = $order->ID;
            } else {
                // Insert into Order
                $result = $wpdb->insert( $tblOrders, array(
                    'user_id' => $current_user->ID,
                    'level_id' => $level_id,
                    'payment_method' => 'Nganluong',
                    'discount' => 0,
                    'total_amount' => $price,
                    'affiliate_id' => '',
                    'updated_date' => date('Y-m-d H:i:s'),
                ), array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                ) );
                if($result){
                    $order_code = $wpdb->insert_id;
                }
            }

            if($order_code > 0){
                $receiver = "info@batdongsan.vn";
                $return_url = get_page_link(get_option('online_payment_result'));
                $url = $nl_checkout->buildCheckoutUrl($return_url, $receiver, $current_user->ID, $order_code, $price);

                Response(json_encode(array(
                    'status' => 'success',
                    'message' => "Kiểm tra hợp lệ, chúng tôi sẽ chuyển sang cổng thanh toán Ngân Lượng ngay bây giờ.",
                    'redirect_url' => $url,
                )));
            } else {
                Response(json_encode(array(
                    'status' => 'error',
                    'message' => 'Xảy ra lỗi, vui lòng thử lại hoặc liên hệ quản trị viên để được trợ giúp!',
                )));
            }
        }
    }

    exit;
}
/**
 * Add rating for user
 */
function add_user_rating(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $value = getRequest('value');
    $user_id = intval(getRequest('user_id'));
    $user = get_user_by( 'ID', $user_id );
    if($user){
        global $wpdb;
        $tbl_user_ratings = $wpdb->prefix . 'user_ratings';
        $rating = $wpdb->get_row( "SELECT * FROM {$tbl_user_ratings} WHERE rating_userid={$user_id} AND rating_ip='{$ip}'" );
        if($rating and isset($_COOKIE["rated_user_" . $user_id])){
            Response(json_encode(array(
                'status' => 'success',
                'message' => 'Bạn đã đánh giá thành viên này!',
            )));
        } else {
            $result = $wpdb->insert( $tbl_user_ratings, array(
                'rating_userid' => $user_id,
                'rating_rating' => $value,
                'rating_timestamp' => strtotime('now'),
                'rating_ip' => $ip,
            ), array(
                '%d',
                '%d',
                '%s',
                '%s',
            ) );
            if($result){
                setcookie("rated_user_" . $user_id, $value, time()+3600*24, '/', '');  /* expire in 1 day */
                Response(json_encode(array(
                    'status' => 'success',
                    'message' => 'Cám ơn đánh giá của bạn!',
                    'rating' => ppo_user_ratings($user_id),
                )));
            } else {
                Response(json_encode(array(
                    'status' => 'error',
                    'message' => 'Xảy ra lỗi!',
                )));
            }
        }
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Xảy ra lỗi!',
        )));
    }
    exit;
}