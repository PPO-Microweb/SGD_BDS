<?php
if (!function_exists('country_list')) {

    function country_list() {
        return array(
            "Afghanistan",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombi",
            "Comoros",
            "Congo (Brazzaville)",
            "Congo",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor (Timor Timur)",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia, The",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, North",
            "Korea, South",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macedonia",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syria",
            "Taiwan",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        );
    }

}
function family_status(){
    return array(
        'notmarried' => 'Chưa lập gia đình', 
        'married' => 'Đã lập gia đình', 
        'divorced' => 'Đã ly hôn',
    );
}
function gender_list(){
    return array('male' => 'Nam', 'female' => 'Nữ');
}
function user_exp_list() {
    return array(
        0 => 'Chưa có',
        1 => '1 năm',
        2 => '2 năm',
        3 => '3 năm',
        'n' => 'Nhiều năm'
    );
}
function education_list(){
    return array(
        'phothong' => 'Phổ thông',
        'daihoc' => 'Đại học',
        'saudaihoc' => 'Sau đại học',
    );
}
function chuyen_nganh_list(){
    return array(
        'quantrikd' => 'Quản trị kinh doanh',
        'marketing' => 'Marketing & Quảng cáo',
        'phapluat' => 'Pháp luật',
        'thietkekientruc' => 'Thiết kế và Kiến trúc',
        'taichinhnganhang' => 'Tài chính và Ngân hàng',
    );
}
function get_certificates(){
    return array(
        'moigioibds' => 'Môi giới BĐS',
        'dinhgiabds' => 'Định giá BĐS',
        'quanlysanbds' => 'Quản lý Sàn BĐS',
        'dautubds' => 'Đầu tư BĐS',
        'tiepthibds' => 'Tiếp thị BĐS',
    );
}
function get_languages(){
    return array(
        'english' => 'Tiếng Anh',
        'french' => 'Tiếng Pháp',
        'russian' => 'Tiếng Nga',
        'german' => 'Tiếng Đức',
        'korean' => 'Tiếng Hàn',
        'chinese' => 'Tiếng Trung',
        'japanese' => 'Tiếng Nhật',
    );
}
function get_jobs(){
    return array(
        'moigioi' => 'Môi giới BĐS',
        'tuvan' => 'Tư vấn BĐS',
        'dautu' => 'Đầu tư BĐS',
        'tiepthi' => 'Tiếp thị BĐS',
        'kinhdoanh' => 'Kinh doanh BĐS',
        'luatsu' => 'Luật sư BĐS',
        'kientrucsu' => 'Kiến trúc sư',
        'cntt' => 'Công nghệ thông tin',
    );
}
function get_regency_list(){
    return array(
        'nhanvien' => 'Nhân viên',
        'chuyengia' => 'Chuyên gia',
        'truongnhom' => 'Trưởng nhóm',
        'giamdoc' => 'Giám đốc',
        'chudoanhnghiep' => 'Chủ doanh nghiệp',
        'khoinghiep' => 'Khởi nghiệp',
        'tudo' => 'Tự do',
    );
}

add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');
add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

function my_show_extra_profile_fields($user) {
    $districts = get_district(PROVINCE_ID);
?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="gender">Giới tính</label></th>
            <td>
                <select name="gender" id="gender" style="width: 15em;">
                    <?php
                    foreach (gender_list() as $key => $value) {
                        if (esc_attr(get_the_author_meta('gender', $user->ID)) == $key) {
                            echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="family_status">Tình trạng gia đình</label></th>
            <td>
                <select name="family_status" id="family_status" style="width: 15em;">
                    <?php
                    foreach (family_status() as $key => $value) {
                        if (esc_attr(get_the_author_meta('family_status', $user->ID)) == $key) {
                            echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_city">Tỉnh/TP</label></th>
            <td>
                <select name="user_city" id="user_city" style="width: 15em;">
                    <?php
                    $cities = vn_city_list();
                    foreach ($cities as $city) {
                        if (esc_attr(get_the_author_meta('user_city', $user->ID)) == $city) {
                            echo '<option value="' . $city . '" selected="selected">' . $city . '</option>';
                        } else {
                            echo '<option value="' . $city . '">' . $city . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_country">Quốc tịch</label></th>
            <td>
                <select name="user_country" id="user_country" style="width: 15em;">
                    <?php
                    $countries = country_list();
                    foreach ($countries as $country) {
                        if (esc_attr(get_the_author_meta('user_country', $user->ID)) == $country) {
                            echo '<option value="' . $country . '" selected="selected">' . $country . '</option>';
                        } else {
                            echo '<option value="' . $country . '">' . $country . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_exp">Kinh nghiệm</label></th>
            <td>
                <select name="user_exp" id="user_exp" style="width: 15em;">
                    <?php
                    foreach (user_exp_list() as $exp => $val) {
                        if (esc_attr(get_the_author_meta('user_exp', $user->ID)) == $exp) {
                            echo '<option value="' . $exp . '" selected="selected">' . $val . '</option>';
                        } else {
                            echo '<option value="' . $exp . '">' . $val . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="account_level">Cấp bậc tài khoản</label></th>
            <td>
                <select name="account_level" id="account_level" style="width: 15em;">
                    <?php
                    $levels = new WP_Query(array(
                        'post_type' => 'user_level',
                        'showposts' => -1,
                        'post_status' => 'publish',
                        'order' => 'asc'
                    ));
                    while ($levels->have_posts()) : $levels->the_post();
                        if (esc_attr(get_the_author_meta('account_level', $user->ID)) == get_the_ID()) {
                            echo '<option value="' . get_the_ID() . '" selected="selected">' . get_the_title() . '</option>';
                        } else {
                            echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
                        }
                    endwhile;
                    wp_reset_query();
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Giới hạn số tin đăng</label></th>
            <td>
                <input type="text" name="limit_posting" value="<?php echo esc_attr(get_the_author_meta('limit_posting', $user->ID)) ?>" placeholder="20" style="width:210px" /><br/>
                <p class="description">Start: 10, Biz: 50, Pro: 200,...</p>
            </td>
        </tr>
        <tr>
            <th><label>Giới hạn số tin VIP</label></th>
            <td>
                <input type="text" name="limit_postvip" value="<?php echo esc_attr(get_the_author_meta('limit_postvip', $user->ID)) ?>" placeholder="0" style="width:210px" /><br/>
                <p class="description">Start: 0, Biz: 10, Pro: 50,...</p>
            </td>
        </tr>
        <tr>
            <th><label>API Key</label></th>
            <td>
                <input type="text" name="api_key" value="<?php echo md5($user->data->user_login . $user->data->user_pass); ?>" style="width:260px" disabled /><br/>
                <p class="description">API Key sẽ tự động thay đổi khi mật khẩu thay đổi.</p>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="padding-left: 0">
                <h3 style="margin: 0">Thị trường kinh doanh</h3>
            </th>
        </tr>
        <tr>
            <th><label>Phân khúc/Địa bàn (1)</label></th>
            <td>
                <?php
                wp_dropdown_categories(array(
                    'name' => 'bds_segment1', 
                    'taxonomy' => 'product_category', 
                    'selected' => esc_attr(get_the_author_meta('bds_segment1', $user->ID)),
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'value_field' => 'term_id',
                    'class' => '',
                    'id' => '',
                ));
                ?>
                <select name="bds_location1" id="bds_location1" style="width: 15em;margin-left:10px">
                    <?php
                    foreach ($districts as $district) {
                        if (esc_attr(get_the_author_meta('bds_location1', $user->ID)) == $district->districtid) {
                            echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                        } else {
                            echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Phân khúc/Địa bàn (2)</label></th>
            <td>
                <?php
                wp_dropdown_categories(array(
                    'name' => 'bds_segment2', 
                    'taxonomy' => 'product_category', 
                    'selected' => esc_attr(get_the_author_meta('bds_segment2', $user->ID)),
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'value_field' => 'term_id',
                    'class' => '',
                    'id' => '',
                ));
                ?>
                <select name="bds_location2" id="bds_location2" style="width: 15em;margin-left:10px">
                    <?php
                    foreach ($districts as $district) {
                        if (esc_attr(get_the_author_meta('bds_location2', $user->ID)) == $district->districtid) {
                            echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                        } else {
                            echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Phân khúc/Địa bàn (3)</label></th>
            <td>
                <?php
                wp_dropdown_categories(array(
                    'name' => 'bds_segment3', 
                    'taxonomy' => 'product_category', 
                    'selected' => esc_attr(get_the_author_meta('bds_segment3', $user->ID)),
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'value_field' => 'term_id',
                    'class' => '',
                    'id' => '',
                ));
                ?>
                <select name="bds_location3" id="bds_location3" style="width: 15em;margin-left:10px">
                    <?php
                    foreach ($districts as $district) {
                        if (esc_attr(get_the_author_meta('bds_location3', $user->ID)) == $district->districtid) {
                            echo '<option value="' . $district->districtid . '" selected="selected">' . $district->name . '</option>';
                        } else {
                            echo '<option value="' . $district->districtid . '">' . $district->name . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
<?php
}

function my_save_extra_profile_fields($user_id) {
    $user_fields = array(
        "gender", "family_status", "user_city", "user_country", "user_exp",
        "bds_segment1", "bds_segment2", "bds_segment3", 
        "bds_location1", "bds_location2", "bds_location3", 
        "account_level", "limit_posting", "limit_postvip", 
    );

    if (!current_user_can('edit_user', $user_id))
        return false;

    foreach ($user_fields as $field) {
        update_usermeta($user_id, $field, $_POST[$field]);
    }
}

/* BEGIN Custom User Contact Info */
 function extra_contact_info($contactmethods) {
    $contactmethods['phone'] = __('Số điện thoại', SHORT_NAME);
    $contactmethods['workplace_address'] = __('Nơi làm việc', SHORT_NAME);
    
    return $contactmethods;
 }
 
 add_filter('user_contactmethods', 'extra_contact_info');
 /* END Custom User Contact Info */