<?php

ob_start(); // Start output buffering
include('./config/session.php');
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
                    $sqlUpdateStatus = "UPDATE orders SET status = 'cancelled' WHERE order_id = '$orderId'";
                    $message = 'Order has been cancelled Successfully!';
                    // Update the order status based on the conditions
                    mysqli_query($conn, $sqlUpdateStatus);
                    redirectWithMessage($message);
                    break;
                case 'processing':
                    $message = 'Order is already processing, cannot cancel order!';
                    redirectWithMessage($message);
                    break;
                case 'confirmed':
                    $message = 'Order already confirmed, cannot cancel order!';
                    redirectWithMessage($message);
                    break;
                case 'cancelled':
                    $message = 'Order has already been cancelled!';
                    redirectWithMessage($message);
                    break;
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
