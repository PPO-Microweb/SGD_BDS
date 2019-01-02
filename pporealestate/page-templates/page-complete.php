<?php
/*
  Template Name: Online Payment Result
 */
//Lấy thông tin giao dịch
$transaction_info = $_GET["transaction_info"];
//Lấy mã đơn hàng 
$order_code = $_GET["order_code"];
//Lấy tổng số tiền thanh toán tại ngân lượng 
$price = $_GET["price"];
//Lấy mã giao dịch thanh toán tại ngân lượng
$payment_id = $_GET["payment_id"];
//Lấy loại giao dịch tại ngân lượng (1=thanh toán ngay ,2=thanh toán tạm giữ)
$payment_type = $_GET["payment_type"];
//Lấy thông tin chi tiết về lỗi trong quá trình giao dịch
$error_text = $_GET["error_text"];
//Lấy mã kiểm tra tính hợp lệ của đầu vào 
$secure_code = $_GET["secure_code"];

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();
?>
<div class="container main_content payment-result">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <?php
    $html = "";
    global $nl_checkout;
    $check = $nl_checkout->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
    if ($check) {
        $html .= <<<HTML
        <header class="entry-header">
            <h1 class="page-title">GIAO DỊCH THÀNH CÔNG</h1>
        </header>
        <div class="entry-content" style="color:green">
            <p>Cám ơn quý khách, quá trình thanh toán đã được hoàn tất!</p>
        </div>
HTML;
        global $wpdb;
//        $result = $wpdb->update( $wpdb->prefix . 'orders', array(
//            'payment_status' => 1,
//            'nl_payment_id' => $payment_id,
//            'nl_payment_type' => $payment_type,
//            'nl_secure_code' => $secure_code,
//        ), array('ID' => $order_code), array('%d', '%s', '%s', '%s'), array('%d'));

        if ($result) {
            $customer_info = isset($_SESSION['CUSTOMER_INFO']) ? $_SESSION['CUSTOMER_INFO'] : array();
            $coupon_amount = isset($_SESSION['coupon_amount']) ? $_SESSION['coupon_amount'] : 0;

//            sendInvoiceToEmail($customer_info, $coupon_amount, $order_code);
        }
    } else {
        $return_url = get_page_link(get_option('online_payment_result'));
        $receiver = "info@batdongsan.vn";
        $checkout_url = $nl_checkout->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);
        $html .= <<<HTML
        <header class="entry-header">
            <h1 class="page-title">GIAO DỊCH <span class="t_red">KHÔNG</span> THÀNH CÔNG</h1>
        </header>
        <div class="entry-content" style="color:red">
            <p>Vui lòng thực hiện thanh toán lại <a href="{$checkout_url}" style="color:blue">tại đây</a>.</p>
        </div>
HTML;
    }
    echo $html;
    ?>
</div>
<?php get_footer(); ?>