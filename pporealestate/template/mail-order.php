<?php
$order = $attributes['order'];
$customer = $attributes['customer'];
$currency = "VNĐ";
$display_name = trim($customer->user_lastname . ' ' . $customer->user_firstname);
if(empty($display_name)){
    $display_name = $customer->display_name;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div style="margin: 0 auto;font-family: Calibri,sans-serif;line-height: 13px;font-size: 14px;">
    <div style="border-bottom: 2px solid #000;padding-bottom: 10px;margin-bottom: 10px">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: none;width: 100%">
            <tr>
                <td valign="top" style="vertical-align: top">
                    <p><?php _e('Thành viên', SHORT_NAME) ?>: <?php echo $display_name ?></p>
                    <p><?php _e('Điện thoại', SHORT_NAME) ?>: <?php echo get_the_author_meta( 'phone', $customer->ID ); ?></p>
                    <p>Email: <?php echo $customer->user_email ?></p>
                    <p><?php _e('Tỉnh/TP', SHORT_NAME) ?>: <?php echo get_the_author_meta( 'user_city', $customer->ID ) ?></p>
                    <p><?php _e('Quốc gia', SHORT_NAME) ?>: <?php echo get_the_author_meta( 'user_country', $customer->ID ) ?></p>
                </td>
                <td valign="top" style="vertical-align: top;text-align: right">
                    <p>CÔNG TY CP ĐẦU TƯ TIẾP THỊ BẤT ĐỘNG SẢN VIỆT NAM</p>
                    <p><?php _e('Điện thoại', SHORT_NAME) ?>: <?php echo get_option(SHORT_NAME . "_hotline") ?></p>
                    <p>Email: <?php echo $attributes['admin_email'] ?></p>
                    <p><?php _e('Ngày đặt hàng', SHORT_NAME) ?>: <?php echo $order->created_at ?></p>
                    <p>Đơn hàng: #<?php echo $order->ID ?></p>
                </td>
            </tr>
        </table>
    </div>
    <div style="overflow: hidden;">
        <h1 style="text-align: center; font-size: 20px;text-transform: uppercase;">
            <?php _e('THÔNG TIN GIAO DỊCH', SHORT_NAME) ?>
        </h1>
        <div>
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%" width="100%">
                <thead>
                    <tr>
                        <th>Gói dịch vụ</th>
                        <th style="text-align: center;width: 120px">Thời hạn</th>
                        <th style="text-align: right" align="right"><?php _e('Thành tiền', SHORT_NAME) ?> (<?php echo $currency ?>)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo get_the_title($order->level_id) ?>
                        </td>
                        <td style="text-align: center">
                            12 tháng
                        </td>
                        <td style="text-align: right" align="right">
                            <?php echo number_format($order->total_amount,0,',','.'); ?>
                        </td>
                    </tr>
            <?php
//                $vat = $order->total_amount * 0.1;
//                $totalPay = $order->total_amount + $vat;
                $totalPay = $order->total_amount;
                $numToWords = ucfirst(convert_number_to_words($totalPay));
            ?>
                    <tr>
                        <td colspan="2" style="text-align: right;text-transform: uppercase;font-weight: bold;">
                            <?php _e('TỔNG THANH TOÁN', SHORT_NAME) ?>
                        </td>
                        <td style="text-align: right;"><?php echo number_format($totalPay, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
            <h4 style="text-align: right;font-style: italic;">(<?php _e('Bằng chữ', SHORT_NAME) ?>: <?php echo $numToWords ?> <?php _e('đồng', SHORT_NAME) ?>./.)</h4>
        </div>
        <div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: none;width: 100%">
                <tr>
                    <td style="text-align: right;vertical-align: top" align="right" valign="top">
                        <p style="text-align: right;"><?php _e('Hà Nội', SHORT_NAME) ?>, <?php echo date("d/m/Y") ?></p>
                        <h3>CÔNG TY CP ĐẦU TƯ TIẾP THỊ BẤT ĐỘNG SẢN VIỆT NAM</h3>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>