<div id="footer">
    <div class="footer-contact hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <img class="mr15" alt="Contact Us" src="<?php echo THEME_URI ?>assets/images/footer-contact.png" /> 
                    <span class="mr15">HOTLINE: <strong><?php echo get_option(SHORT_NAME . "_hotline") ?></strong></span>
                    <span>Email: <strong><?php echo get_option("info_email") ?></strong></span>
                </div>
                <div class="col-sm-3 btn-wrap">
                    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>" class="btn"><?php _e('Liên hệ', SHORT_NAME) ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer1' ) ) { dynamic_sidebar( 'footer1' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer2' ) ) { dynamic_sidebar( 'footer2' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer3' ) ) { dynamic_sidebar( 'footer3' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3 class="widget-title">MẠNG XÃ HỘI</h3>
                        <!--<p>Theo dõi chúng tôi trên mạng xã hội</p>-->
                        <ul class="socials">
                            <li><a href="<?php echo get_option(SHORT_NAME . "_fbURL") ?>" class="icon-fb"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_googlePlusURL") ?>" class="icon-gplus"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_twitterURL") ?>" class="icon-twitter"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_linkedInURL") ?>" class="icon-in"></a></li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h3 class="widget-title">NEWSLETTER</h3>
                        <!--<p>Đăng ký để nhận bản tin định kỳ</p>-->
                        <div class="newsletter">
                            <?php echo do_shortcode(stripslashes_deep(get_option("follow_form"))); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 left">
                    <span>Copyright &COPY; <a href="http://batdongsan.vn" title="Bất động sản Việt Nam">batdongsan.VN</a>. All rights reserved.</span>
                </div>
                <div class="col-md-6">
                    <?php
                    if ( has_nav_menu( 'footermenu' ) ) {
                        wp_nav_menu(array(
                            'container' => '',
                            'theme_location' => 'footermenu',
                            'menu_class' => 'nav footer-nav',
                            'menu_id' => '',
                        ));
                    } else {
                        _e('Please add a menu to Footer Location', SHORT_NAME);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SUPPORT -->
<section id="floating-buttons">
    <a href="http://fb.com/msg/<?php echo get_option(SHORT_NAME . "_messenger_id") ?>" class="cta cta-messenger" rel="nofollow"><i></i></a>
    <a href="http://zalo.me/<?php echo get_option(SHORT_NAME . "_zalo_phone") ?>" class="cta cta-zalo" rel="nofollow"><i></i></a>
    <a href="#" class="cta cta-support" rel="nofollow"><i class="fa fa-question"></i></a>
    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>" class="cta cta-phone" rel="nofollow"><i class="fa fa-phone"></i></a>
    <div class="wrap-bookmarks">
        <div class="title-bookmarks">
            Chúng tôi có thể giúp gì cho bạn?
            <div class="btn-close pull-right">X</div>
        </div>
        <div class="list-bookmarts">
            <?php
                $bookmarks = get_bookmarks( array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'category' => '',
                    'category_name'  => ''
                ) );
            ?>
            <div class="text-selectbox">Tôi muốn</div> 
            <select id="lstbookmarts">
                <?php foreach ( $bookmarks as $bookmark ) { ?>
                  <?php printf( '<option value="%1$s">%2$s</option>', esc_attr( $bookmark->link_url ), $bookmark->link_name ); ?>
                <?php } ?>
            </select>
            <a class="btn" id="btn-view-link">XEM</a>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-building.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho chủ đầu tư</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-1") ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-home-support.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho chủ nhà</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-2") ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-user-support.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho môi giới</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-3") ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="segments-list-floating" class="hide bounceInDown animated">
    <span class="close">Đóng X</span>
    <div class="container">
        <h3 class="title"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Các loại BĐS</h3>
        <ul>
            <li><a href="http://datnenhanoi.batdongsan.vn" rel="nofollow" style="background:#4F3629">Đất nền</a></li>
            <li><a href="http://datvanghanoi.batdongsan.vn" rel="nofollow" style="background:#FEC300">Đất vàng</a></li>
            <li><a href="http://thocuhanoi.batdongsan.vn" rel="nofollow" style="background:#D3530E">Thổ cư</a></li>
            <li><a href="http://nhamatphohanoi.batdongsan.vn" rel="nofollow" style="background:#025A78">Nhà mặt phố</a></li>
            <li><a href="http://bietthuhanoi.batdongsan.vn" rel="nofollow" style="background:#003399">Biệt thự</a></li>
            <li><a href="http://nhacohanoi.batdongsan.vn" rel="nofollow" style="background:#996633">Nhà cổ</a></li>
            <li><a href="http://nhatrohanoi.batdongsan.vn" rel="nofollow" style="background:#118AE9">Nhà trọ</a></li>
            <li><a href="http://luxuryhomehanoi.batdongsan.vn" rel="nofollow" style="background:#85001D">Luxury Home</a></li>
            <li><a href="http://canhobinhdanhanoi.batdongsan.vn" rel="nofollow" style="background:#FDBE56">Căn hộ bình dân</a></li>
            <li><a href="http://canhotapthehanoi.batdongsan.vn" rel="nofollow" style="background:#DAA404">Căn hộ tập thể</a></li>
            <li><a href="http://canhotunhanhanoi.batdongsan.vn" rel="nofollow" style="background:#660033">Căn hộ tư nhân</a></li>
            <li><a href="http://nhaoxahoihanoi.batdongsan.vn" rel="nofollow" style="background:#FFFF00">Nhà ở xã hội</a></li>
            <li><a href="http://canhocaocaphanoi.batdongsan.vn" rel="nofollow" style="background:#181C4B">Căn hộ cao cấp</a></li>
            <li><a href="http://condotelhanoi.batdongsan.vn" rel="nofollow" style="background:#393060">Condotel</a></li>
            <li><a href="http://officetelhanoi.batdongsan.vn" rel="nofollow" style="background:#0033CC">Officetel</a></li>
            <li><a href="http://hometelhanoi.batdongsan.vn" rel="nofollow" style="background:#003263">Hometel</a></li>
            <li><a href="http://penhousehanoi.batdongsan.vn" rel="nofollow" style="background:#1C3248">Penthouse</a></li>
            <li><a href="http://shophousehanoi.batdongsan.vn" rel="nofollow" style="background:#4D5B41">Shophouse</a></li>
            <li><a href="http://bietthunghiduonghanoi.batdongsan.vn" rel="nofollow" style="background:#005260">Biệt thự nghỉ dưỡng</a></li>
            <li><a href="http://homestayhanoi.batdongsan.vn" rel="nofollow" style="background:#FF3300">Homestay</a></li>
            <li><a href="http://timesharehanoi.batdongsan.vn" rel="nofollow" style="background:#0070C0">Time share</a></li>
            <li><a href="http://apartmenthanoi.batdongsan.vn" rel="nofollow" style="background:#CC0066">Apartment</a></li>
            <li><a href="http://duonglaohanoi.batdongsan.vn" rel="nofollow" style="background:#DAA435">Dưỡng lão</a></li>
            <li><a href="http://kidhousehanoi.batdongsan.vn" rel="nofollow" style="background:#FF0000">Kid House</a></li>
            <li><a href="http://thuongmaihanoi.batdongsan.vn" rel="nofollow" style="background:#00B5C4">BĐS thương mại</a></li>
            <li><a href="http://khachsanhanoi.batdongsan.vn" rel="nofollow" style="background:#F28226">Khách sạn</a></li>
            <li><a href="http://nhahanghanoi.batdongsan.vn" rel="nofollow" style="background:#C00000">Nhà hàng</a></li>
            <li><a href="http://resorthanoi.batdongsan.vn" rel="nofollow" style="background:#0070C0">Resort</a></li>
            <li><a href="http://trangtraihanoi.batdongsan.vn" rel="nofollow" style="background:#36A800">Trang trại</a></li>
            <li><a href="http://khobaihanoi.batdongsan.vn" rel="nofollow" style="background:#788494">Kho bãi nhà xưởng</a></li>
            <li><a href="http://khucongnghiep.batdongsan.vn" rel="nofollow" style="background:#173660">Khu công nghiệp</a></li>
            <li><a href="http://khudothihanoi.batdongsan.vn" rel="nofollow" style="background:#F28226">Khu đô thị</a></li>
            <li><a href="http://tinyhousehanoi.batdongsan.vn" rel="nofollow" style="background:#7030A0">Tiny House</a></li>
            <li><a href="http://mobilehomehanoi.batdongsan.vn" rel="nofollow" style="background:#FF0066">Mobile House</a></li>
            <li><a href="http://smarthomehanoi.batdongsan.vn" rel="nofollow" style="background:#507BAF">Smart House</a></li>
            <li><a href="http://vanphonghanoi.batdongsan.vn" rel="nofollow" style="background:#09086E">Văn phòng</a></li>
            <li><a href="http://vanphongaohanoi.batdongsan.vn" rel="nofollow" style="background:#0D61A1">Văn phòng ảo</a></li>
            <li><a href="http://coworkinghanoi.batdongsan.vn" rel="nofollow" style="background:#808000">Coworking Space</a></li>
            <li><a href="http://duanhanoi.batdongsan.vn" rel="nofollow" style="background:#C00000">Dự án bất động sản</a></li>
            <li><a href="javascript://" style="background:#808080"><span class="glyphicon glyphicon-plus"></span></a></li>
        </ul>
    </div>
</div>

<!-- HOTLINE -->
<div class="callus">
    <i class="glyphicon glyphicon-earphone"></i>
    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>"><?php echo get_option(SHORT_NAME . "_hotline") ?></a>
</div>

<!--POPUP-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="border: none;border-radius: 0;background: none;box-shadow: none">
            <div class="modal-header" style="border-bottom: none">
                <button type="button" class="close" data-dismiss="modal" style="margin-top: 4px">&times;</button>
                <h4 class="modal-title hide hidden">QUẢNG CÁO</h4>
            </div>
            <div class="modal-body t_center" style="padding: 0">
                <?php echo stripslashes(get_option('banner_popup')) ?>
            </div>
            <div class="modal-footer hide hidden">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="scrollToTop"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
<div id="fb-root"></div>
<?php wp_footer(); ?>
<noscript id="deferred-styles">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300italic,300,700,700italic,400italic&subset=vietnamese,latin" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=BenchNine:400" rel="stylesheet" />
</noscript>
<script>
var loadDeferredStyles = function() {
  var addStylesNode = document.getElementById("deferred-styles");
  var replacement = document.createElement("div");
  replacement.innerHTML = addStylesNode.textContent;
  document.body.appendChild(replacement);
  addStylesNode.parentElement.removeChild(addStylesNode);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
    webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf){ raf(function() { window.setTimeout(loadDeferredStyles, 0); });}
else{ window.addEventListener('load', loadDeferredStyles);}
</script>
</body>
</html>
