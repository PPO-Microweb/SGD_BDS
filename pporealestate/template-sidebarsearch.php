<?php
$list_city = get_province();
$directions = direction_list();
$rooms = room_list();
$areas = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_acreage',
    'hide_empty' => 1,
));
$prices = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_price',
    'hide_empty' => 1,
));
$projects = new WP_Query(array(
    'post_type' => 'project',
    'showposts' => -1,
    'post_status' => 'publish',
));
$purposes = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_purpose',
    'hide_empty' => 1,
));
$specials = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_special',
    'hide_empty' => 1,
));
?>
<div class="widget box-search pb10">
    <ul class="nav nav-tabs responsive" id="boxTab">
        <li class="test-class active"><a data-id="sell" href="#tab1">Cần Bán</a></li>
        <li class="test-class"><a data-id="rent" href="#tab2">Cho Thuê</a></li>
        <li class="test-class"><a data-id="invest" href="#tab3">Đầu Tư</a></li>
    </ul>
    <div class="tab-content box-content responsive">
        <div class="tab-pane active">
            <form method="get" action="<?php bloginfo('siteurl') ?>">
                <ul class="tab_select">
                    <li>
                        <?php
                        wp_dropdown_categories(array(
                            'show_option_all' => __('- Loại nhà đất -', SHORT_NAME),
                            'name' => 'category', 
                            'taxonomy' => 'product_category', 
                            'selected' => getRequest('category'),
                            'hierarchical' => true,
                            'value_field' => 'term_id',
                            'class' => '',
                            'id' => 'category',
                        ));
                        ?>
                    </li>
                    <li>
                        <select name="city" id="ddlCity" >
                            <option value="">- Thành phố -</option>
                            <?php
                            foreach ($list_city as $c) {
                                echo '<option value="' . $c->provinceid . '">' . $c->name . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="district" id="ddlDistrict" >
                            <option value="">- Quận/ Huyện -</option>
                        </select>
                    </li>
                    <li>
                        <select name="ward" id="ddlWard" >
                            <option value="">- Phường/ Xã -</option>
                        </select>
                    </li>
                    <li>
                        <select name="purpose" id="product_purpose" >
                            <option value="">- Phù hợp để -</option>
                            <?php
                            $purposeID = intval(getRequest('product_purpose'));
                            foreach ($purposes as $purpose) :
                                if ($purposeID == $purpose->term_id) {
                                    echo "<option value=\"{$purpose->term_id}\" selected>{$purpose->name}</option>";
                                } else {
                                    echo "<option value=\"{$purpose->term_id}\">{$purpose->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="area" id="area" >
                            <option value="">- Diện tích -</option>
                            <?php
                            $areaID = intval(getRequest('area'));
                            foreach ($areas as $area) :
                                if ($areaID == $area->term_id) {
                                    echo "<option value=\"{$area->term_id}\" selected>{$area->name}</option>";
                                } else {
                                    echo "<option value=\"{$area->term_id}\">{$area->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="price" id="price" >
                            <option value="">- Giá -</option>
                            <?php
                            $priceID = intval(getRequest('price'));
                            foreach ($prices as $price) :
                                if ($priceID == $price->term_id) {
                                    echo "<option value=\"{$price->term_id}\" selected>{$price->name}</option>";
                                } else {
                                    echo "<option value=\"{$price->term_id}\">{$price->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="room" id="room" >
                            <option value="">- Số phòng ngủ -</option>
                            <?php
                            foreach ($rooms as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="direction" id="direction" >
                            <option value="">- Hướng -</option>
                            <?php
                            foreach ($directions as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="project" id="project" >
                            <option value="">- Dự án -</option>
                            <?php
                            while($projects->have_posts()): $projects->the_post();
                                echo '<option value="'. get_the_ID().'">'. get_the_title().'</option>';
                            endwhile;
                            wp_reset_query();
                            ?>
                        </select>
                    </li>
                    <li>
                        <select name="special" id="special" >
                            <option value="">- Đặc điểm -</option>
                            <?php
                            $specialID = intval(getRequest('special'));
                            foreach ($specials as $special) :
                                if ($specialID == $special->term_id) {
                                    echo "<option value=\"{$special->term_id}\" selected>{$special->name}</option>";
                                } else {
                                    echo "<option value=\"{$special->term_id}\">{$special->name}</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </li>
                    <li class="btnsearch">
                        <input type="hidden" name="s" value="" />
                        <input type="hidden" name="trantype" value="sell" />
                        <input type="submit" value="Tìm kiếm" class="btnSearch"/>
                        <div class="clear"></div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>