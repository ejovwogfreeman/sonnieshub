<?php
include('admincheck.php');
include('../config/db.php');
// include('../partials/header.php');

function redirectWithMessage($message)
{
    header('Location: /a2z_food/index.php?message=' . urlencode($message));
    exit();
}

if (isset($_SESSION['user'])) {
    // Check if order_id is provided in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $productId = $_GET['id'];

        // Delete the product
        $sqlDeleteProduct = "DELETE FROM products WHERE product_id = $productId";
        $result = mysqli_query($conn, $sqlDeleteProduct);

        if ($result) {
            $message = 'Product Deleted Successfully';
            redirectWithMessage($message);
        } else {
            // Error occurred during deletion
            $message = 'Error deleting product: ' . mysqli_error($conn);
            redirectWithMessage($message);
        }
    } else {
        // Redirect to a page where product_id is provided
        redirectWithMessage('Product ID not provided');
    }
} else {
    // Redirect to login page if user is not logged in
    redirectWithMessage('You are not logged in');
}
