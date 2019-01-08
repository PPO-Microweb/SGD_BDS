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
        );
    }

    /**
     * Prepare the table with different parameters, pagination, columns and table elements
     */
    function prepare_items() {
        global $wpdb;
        $tblOrders = $wpdb->prefix . 'orders';
        $order_id = intval($_GET['order_id']);
        
        /* -- Preparing your query -- */
        $queryOrder = "SELECT * FROM $tblOrders WHERE ID = $order_id ";

        /* -- Register the Columns -- */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $wpdb->get_results($queryOrder);

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
        }elseif($ordersRow->payment_method == 'Nganluong'){
            $paymentMethod = "Ngân Lượng";
        }
        $user_info = get_userdata($ordersRow->user_id);
        $user_phone = esc_attr(get_the_author_meta('phone', $ordersRow->user_id));
        $user_address = esc_attr(get_the_author_meta('workplace_address', $ordersRow->user_id));
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
                            echo $this->column_title($rec);
                            echo '</td>';
                            break;
                        case "col_orders_duration":
                            echo '<td ' . $attributes . '>';
                            _e('12 tháng', SHORT_NAME);
                            echo '</td>';
                            break;
                        case "col_orders_expiry":
                            echo '<td ' . $attributes . '>';
                            $created_at = date('Y/m/d', strtotime($rec->created_at));
                            echo date("Y/m/d", strtotime("$created_at+1 years"));
                            echo '</td>';
                            break;
                        case "col_orders_amount":
                            echo '<td ' . $attributes . '>' . number_format(get_field('price', $rec->level_id), 0, ',', '.') . ' VNĐ</td>';
                            break;
                    }
                }

                //Close the line
                echo'</tr>';
            }
        }
    }
    
    function column_title($item) {
//        $permalink = get_permalink( $item->level_id );
        $actions = array(
            'edit' => sprintf('<a href="post.php?post=%s&action=edit">Edit</a>', $item->level_id),
//            'view' => sprintf('<a href="%s">View</a>', $permalink),
        );
        return sprintf('%1$s %2$s',stripslashes( get_the_title($item->level_id) ), $this->row_actions($actions));
    }

}