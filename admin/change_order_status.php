<?php

ob_start(); // Start output buffering
include('admincheck.php');
include('./config/db.php');

function redirectWithMessage($message)
{
    header('Location: /sonnieshub/dashboard/');
    $_SESSION['msg'] = $message;
}

if (isset($_SESSION['user'])) {
    if (isset($orderId)) {

        // Fetch order details
        $sqlOrder = "SELECT * FROM orders WHERE order_id = '$orderId'";
        $resultOrder = mysqli_query($conn, $sqlOrder);
        $order = mysqli_fetch_assoc($resultOrder);

        if ($order) {
            // Check the current status of the order
            switch ($order['status']) {
                case 'pending':
                    // Change status to 'Processing'
                    $sqlUpdateStatus = "UPDATE orders SET status = 'processing' WHERE order_id = '$orderId'";
                    $message = 'Order moved to Processing Successfully!';
                    // Update the order status based on the conditions
                    mysqli_query($conn, $sqlUpdateStatus);
                    redirectWithMessage($message);
                    break;
                case 'processing':
                    // Check if the status is 'Cancelled'
                    if ($order['status'] === 'cancelled') {
                        $message = 'Cannot process a cancelled order!';
                        redirectWithMessage($message);
                    } else {
                        // Change status to 'Confirmed'
                        $sqlUpdateStatus = "UPDATE orders SET status = 'confirmed' WHERE order_id = '$orderId'";

                        $referee_id = $order['user_id'];

                        $referee_sql = "SELECT * FROM users WHERE user_id = '$referee_id'";
                        $referee_query = mysqli_query($conn, $referee_sql);
                        $referee = mysqli_fetch_assoc($referee_query);

                        $referee_username = $referee['username'];
                        $referrer_code = $referee['referrer_code'];

                        if (!empty($referrer_code)) {

                            $referrer_sql = "SELECT * FROM users WHERE username = '$referrer_code'";
                            $referrer_query = mysqli_query($conn, $referrer_sql);
                            $referrer = mysqli_fetch_assoc($referrer_query);

                            $referrer_id = $referrer['user_id'];

                            // Fetch the order items
                            $sqlOrderItems = "SELECT * FROM order_items WHERE order_id = '$orderId'";
                            $resultOrderItems = mysqli_query($conn, $sqlOrderItems);
                            $orderItems = mysqli_fetch_all($resultOrderItems, MYSQLI_ASSOC);

                            $message = 'Order Confirmed Successfully!';
                            mysqli_query($conn, $sqlUpdateStatus);
                        } else {
                            $message = 'Order Confirmed Successfully!';
                            mysqli_query($conn, $sqlUpdateStatus);
                        }
                    }
                    redirectWithMessage($message);
                    break;
                case 'confirmed':
                    // Check if the status is 'Cancelled'
                    if ($order['status'] === 'cancelled') {
                        $message = 'Cannot process a cancelled order!';
                        redirectWithMessage($message);
                    } else if ($order['status'] === 'confirmed') {
                        $message = 'Order is already Confirmed';
                        redirectWithMessage($message);
                        break;
                    }
                case 'cancelled':
                    $message = 'Order has already been cancelled!';
                    redirectWithMessage($message);
                default:
                    $message = 'Invalid Order Status';
                    redirectWithMessage($message);
                    break;
            }
        } else {
            // Order not found
            $message = 'Invalid Order ID';
            redirectWithMessage($message);
        }
    } else {
        // Redirect to a page where order_id is provided
        $message = 'Order ID not provided';
        redirectWithMessage($message);
    }
}

ob_end_flush(); // Flush the output buffer
