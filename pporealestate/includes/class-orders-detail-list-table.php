<?php

if (!class_exists('WP_List_Table'))
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class WPOrders_Detail_List_Table extends WP_List_Table {

    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
    function __construct() {
        parent::__construct(array(
            'singular' => 'wp_orders_detail', //Singular label
            'plural' => 'wp_orders_details', //plural label, also this well be one of the table css class
            'ajax' => false //We won't support Ajax for this table
        ));
    }

    /**
     * Add extra markup in the toolbars before or after the list
     * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
     */
    function extra_tablenav($which) {
        if ($which == "top") {
            //The code that goes before the table is here
            echo "<h3>Danh sách dịch vụ:</h3>";
        }
        if ($which == "bottom") {
        }
    }

    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    function get_columns() {
        return $columns = array(
            'col_orders_name' => __('Dịch vụ', SHORT_NAME),
            'col_orders_duration' => __('Thời hạn', SHORT_NAME),
            'col_orders_expiry' => __('Hết hạn', SHORT_NAME),
            'col_orders_amount' => __('Thành tiền', SHORT_NAME),
            'col_orders_status' => __('Trạng thái', SHORT_NAME),
            'col_orders_options' => __('Tùy chọn', SHORT_NAME)
        );
    }

    /**
     * Prepare the table with different parameters, pagination, columns and table elements
     */
    function prepare_items() {
        global $wpdb;
        $tblOrders = $wpdb->prefix . 'orders';
        $order_details = $wpdb->prefix . 'orders_details';
        $order_id = intval($_GET['order_id']);
        
        /* -- Preparing your query -- */
        $queryOrder = "SELECT * FROM $tblOrders WHERE ID = $order_id ";
        $queryOrderDetails = "SELECT * FROM $order_details WHERE order_id = $order_id ";

        /* -- Register the Columns -- */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $wpdb->get_results($queryOrderDetails);

        /* -- Fetch the items -- */
        $ordersRow = $wpdb->get_row($queryOrder);
        $discount = number_format($ordersRow->discount, 0, ',', '.');
        $total_amount = number_format($ordersRow->total_amount, 0, ',', '.');
        $orderCreatedDate = date("d/m/Y H:i", strtotime($ordersRow->created_at));
        $orderUpdatedDate = date("d/m/Y H:i", strtotime($ordersRow->updated_date));
        
        $orderStatus = "";
        $paymentStatus = "";
        $orderStatusArray = array(0 => 'Đang chờ', 1 => 'Đang xử lý', 2 => 'Hoàn thành', 3 => 'Hủy');
        $paymentStatusArray = array(0 => 'Đang chờ', 1 => 'Đã thanh toán', 2 => 'Hủy');
        foreach ($orderStatusArray as $key => $value) {
            $orderStatus .= '<option value="' . $key . '" '. ( ($ordersRow->order_status == $key)?"selected":"" ) .'>' . $value . '</option>';
        }
        foreach ($paymentStatusArray as $key => $value) {
            $paymentStatus .= '<option value="' . $key . '" '. ( ($ordersRow->payment_status == $key)?"selected":"" ) .'>' . $value . '</option>';
        }
        $paymentMethod = "ATM/Internet Banking";
        if($ordersRow->payment_method == 'cash'){
            $paymentMethod = "Tiền mặt";
        }elseif($ordersRow->payment_method == 'online'){
            $paymentMethod = "Ngân Lượng";
        }
        $user_info = get_userdata($ordersRow->user_id);
        $user_phone = esc_attr(get_the_author_meta('phone', $ordersRow->user_id));
        $user_address = esc_attr(get_the_author_meta('address', $ordersRow->user_id));
        echo <<<HTML
    <table>
        <tr>
            <td width="150">Mã khách hàng:</td>
            <td><a href="user-edit.php?user_id={$ordersRow->user_id}" target="_blank">#{$ordersRow->user_id}</a></td>
        </tr>
        <tr>
            <td>Tên khách hàng:</td>
            <td>{$user_info->display_name}</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><a href="mailto:{$user_info->user_email}">{$user_info->user_email}</a></td>
        </tr>
        <tr>
            <td>Số điện thoại:</td>
            <td><a href="tel:{$user_phone}">{$user_phone}</a></td>
        </tr>
        <tr>
            <td>Địa chỉ:</td>
            <td>{$user_address}</td>
        </tr>
    </table>
    <h2 style="font-size: 23px;font-weight: 400;">Thông tin đơn hàng</h2>
    <form action="" method="post" id="frmUpdateOrder">
        <table>
            <tr>
                <td>Mã đơn hàng:</td>
                <td>#{$ordersRow->ID}</td>
            </tr>
            <tr>
                <td>Ngày tạo đơn hàng:</td>
                <td>{$orderCreatedDate}</td>
            </tr>
            <tr>
                <td>Ngày cập nhật:</td>
                <td>{$orderUpdatedDate}</td>
            </tr>
            <tr>
                <td>Chiết khấu:</td>
                <td>{$discount} VNĐ</td>
            </tr>
            <tr>
                <td>Tổng thanh toán:</td>
                <td><strong style="color:red">{$total_amount} VNĐ</strong></td>
            </tr>
            <tr>
                <td>Thanh toán qua:</td>
                <td>{$paymentMethod}</td>
            </tr>
                <tr>
                <td>Trạng thái đơn hàng:</td>
                <td>
                    <select name="order_status" style="width:15em">
                        {$orderStatus}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Trạng thái thanh toán:</td>
                <td>
                    <select name="payment_status" style="width:15em">
                        {$paymentStatus}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ghi chú:</td>
                <td>
                    <textarea name="notes" rows="5" cols="50">{$ordersRow->notes}</textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="button button-large button-primary btn-submit">Lưu thay đổi</button>
                    <input type="hidden" name="order_id" value="{$ordersRow->ID}" />
                    <input type="hidden" name="action" value="ppo_update_order" />
                </td>
            </tr>
        </table>
    </form>
HTML;
    }

    /**
     * Display the rows of records in the table
     * @return string, echo the markup of the rows
     */
    function display_rows() {
        
        $today = date('Y-m-d');

        //Get the records registered in the prepare_items method
        $records = $this->items;

        //Get the columns registered in the get_columns and get_sortable_columns methods
        list( $columns, $hidden ) = $this->get_column_info();

        //Loop for each record
        if (!empty($records)) {
            foreach ($records as $rec) {
                $product_info = json_decode($rec->product_info);

                //Open the line
                echo '<tr id="record_' . $rec->id . '">';
                foreach ($columns as $column_name => $column_display_name) {

                    //Style attributes for each col
                    $class = "class='$column_name column-$column_name'";
                    $style = ' style="vertical-align: middle;"';
                    if (in_array($column_name, $hidden))
                        $style = ' style="display:none;"';
                    $attributes = $class . $style;

                    //Display the cell
                    switch ($column_name) {
                        case "col_orders_name":
                            echo '<td ' . $attributes . '>';
                            echo '<div>' . get_cmd_name($rec->cmd) . ': <strong>' . $rec->domain . '</strong></div>';
                            if(in_array($rec->cmd, array('REG HOSTING', 'RENEW HOSTING', 'REG SSL', 'RENEW SSL'))) {
                                echo 'Gói: <strong>' . get_the_title($rec->package_id) . '</strong>';
                            } else if(in_array($rec->cmd, array('REG VPS', 'RENEW VPS'))){
                                echo '<div>Gói: <strong>' . get_the_title($rec->package_id) . '</strong></div>';
                                echo '<div>HĐH: <strong>' . $product_info->os . '</strong></div>';
                                echo '<div>Phiên bản: <strong>' . $product_info->os_version . '</strong></div>';
                            } else if($rec->cmd == 'REG EGA'){
                                echo '<div>Gói: <strong>' . get_the_title($rec->package_id) . '</strong></div>';
                                echo '<div>Email khôi phục: <strong>' . $product_info->restore_email . '</strong></div>';
                            }
//                            echo $this->column_title($rec);
                            echo '</td>';
                            break;
                        case "col_orders_duration":
                            echo '<td ' . $attributes . '>';
                            if(in_array($rec->cmd, array('REG DOMAIN', 'RENEW DOMAIN', 'TRANSFER DOMAIN'))){
                                echo $rec->duration . ' năm';
                            } else if(in_array($rec->cmd, array('REG HOSTING', 'RENEW HOSTING', 'REG VPS', 'RENEW VPS'))) {
                                echo billingcycle($rec->duration);
                            } else if($rec->cmd == 'REG EGA') {
                                _e('Trọn đời', SHORT_NAME);
                            }
                            echo '</td>';
                            break;
                        case "col_orders_expiry":
                            echo '<td ' . $attributes . '>' . date('d/m/Y', strtotime($rec->expiry_date)) . '</td>';
                            break;
                        case "col_orders_amount":
                            echo '<td ' . $attributes . '>' . number_format($rec->amount, 0, ',', '.') . ' VNĐ</td>';
                            break;
                        case "col_orders_status":
                            echo '<td ' . $attributes . '>';
                            if($rec->status == 0){
                                echo '<span style="color:red">Không hoạt động</span>';
                            } else if($rec->status == 1){
                                echo 'Chờ duyệt';
                            } else if($rec->status == 2){
                                echo '<span style="color:green">Đang hoạt động</span>';
                            } else if($rec->status == 3){
                                echo '<span style="color:red">Đã hủy</span>';
                            }
                            echo '</td>';
                            break;
                        case "col_orders_options": 
                            $viewlink = '?page=nvt_orders&action=order-item-details&id=' . (int) $rec->ID;
                            echo '<td ' . $attributes . '>';
                            echo '<a href="' . $viewlink . '" class="button" title="Xem" target="_blank"><span class="dashicons dashicons-visibility"></span></a> ';
                            
                            if(in_array($rec->cmd, array('REG DOMAIN', 'REG HOSTING')) and $rec->status == 1){
                                
                                $expiry_date = date("Y-m-d", strtotime($rec->expiry_date));
                                if(in_array($rec->cmd, array('REG DOMAIN', 'TRANSFER DOMAIN', 'REG SSL'))){
                                    $expiry_date = date("Y-m-d", strtotime("$today+$rec->duration years"));
                                }else if(in_array($rec->cmd, array('REG HOSTING', 'REG VPS'))){
                                    $months = billingcycle_month($rec->duration);
                                    $expiry_date = date("Y-m-d", strtotime("$today+$months months"));
                                }
                                echo <<<HTML
                                <form action="" method="post" id="frmOrderItemUpdate_{$rec->ID}" style="display:inline-block">
                                    <input type="hidden" name="action" value="ppo_update_order_item" />
                                    <input type="hidden" name="item_id" value="{$rec->ID}" />
                                    <input type="hidden" name="expiry_date" value="{$expiry_date}" />
                                    <input type="hidden" name="status" value="2" />
                                    <input type="hidden" name="notes" value="" />
                                    <button class="button" type="button" title="Duyệt"><span class="dashicons dashicons-yes"></span></button>
                                </form>
HTML;
                            }
                            if($rec->cmd == 'RENEW HOSTING' and $rec->status == 2){
                                echo <<<HTML
                                <form action="" method="post" id="frmSendHostingInfo_{$rec->ID}" style="display:inline-block">
                                    <input type="hidden" name="action" value="send_hosting_info" />
                                    <input type="hidden" name="item_id" value="{$rec->ID}" />
                                    <button class="button" type="button" title="Gửi thông tin hosting"><span class="dashicons dashicons-email-alt"></span></button>
                                </form>
HTML;
                            }
//                            if($rec->cmd == 'RENEW DOMAIN' and $rec->status == 2){
//                                $authorizeCode = md5(md5($rec->domain) . md5("862ae88t"));
//                                $dns_link = 'http://access.ppo.vn/login.php?domain='.$rec->domain.'&uid=392337&authorizeCode='.$authorizeCode.'&returnURL=%2Findex.php%3Fview%3D1';
//                                echo '<a href="' . $dns_link . '" class="button" title="Cài đặt DNS" target="_blank"><span class="dashicons dashicons-admin-generic"></span></a>';
//                            }
                            echo '</td>';
                            break;
                    }
                }

                //Close the line
                echo'</tr>';
            }
        }
    }
    
    function column_title($item) {
        $permalink = get_permalink( $item->id );
        $actions = array(
            'edit' => sprintf('<a href="post.php?post=%s&action=edit">Edit</a>', $item->id),
            'view' => sprintf('<a href="%s">View</a>', $permalink),
        );
        return sprintf('%1$s %2$s',stripslashes( $item->title ), $this->row_actions($actions));
    }

}