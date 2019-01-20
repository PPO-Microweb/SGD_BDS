<?php
$list_city = get_province();
$directions = direction_list();
$rooms = room_list();
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
$areas = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_acreage',
    'hide_empty' => 1,
));
$specials = get_categories(array(
    'type' => 'product',
    'taxonomy' => 'product_special',
    'hide_empty' => 1,
));
?>
<h3 class="form-title hide">Tìm bất động sản</h3>
<ul class="nav nav-tabs responsive" id="myTab">
    <li class="test-class active"><a data-id="sell" href="#tab1"><span>Cần bán</span></a></li>
    <li class="test-class"><a data-id="rent" href="#tab2"><span>Cho thuê</span></a></li>
    <li class="test-class"><a data-id="invest" href="#tab3"><span>Đầu tư</span></a></li>
</ul>
<div class="tab-content top-content-search responsive">
    <div class="tab-pane active">
        <form method="get" action="<?php bloginfo('siteurl') ?>">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-6">
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
                                'class' => 'form-control',
                                'id' => 'category',
                            ));
                            ?>
                        </li>
                        <li>
                            <select name="price" id="price" class="form-control">
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="city" id="ddlCity" class="form-control">
                                <option value="">- Thành phố -</option>
                                <?php
                                foreach ($list_city as $c) {
                                    echo '<option value="' . $c->provinceid . '">' . $c->name . '</option>';
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <select name="room" id="room" class="form-control">
                                <option value="">- Số phòng ngủ -</option>
                                <?php
                                foreach ($rooms as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="district" id="ddlDistrict" class="form-control">
                                <option value="">- Quận/ Huyện -</option>
                            </select>
                        </li>
                        <li>
                            <select name="direction" id="direction" class="form-control">
                                <option value="">- Hướng -</option>
                                <?php
                                foreach ($directions as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="ward" id="ddlWard" class="form-control">
                                <option value="">- Phường/ Xã -</option>
                            </select>
                        </li>
                        <li>
                            <select name="project" id="project" class="form-control">
                                <option value="">- Dự án -</option>
                                <?php
                                while($projects->have_posts()): $projects->the_post();
                                    echo '<option value="'. get_the_ID().'">'. get_the_title().'</option>';
                                endwhile;
                                wp_reset_query();
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="purpose" id="product_purpose" class="form-control">
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
                            <select name="special" id="special" class="form-control">
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
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="tab_select">
                        <li>
                            <select name="area" id="area" class="form-control">
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
                            <input type="submit" value="Tìm kiếm" class="btnSearch"/>
                            <input type="hidden" name="s" value="" />
                            <input type="hidden" name="trantype" value="sell" />
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>