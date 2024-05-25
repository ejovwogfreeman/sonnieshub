<?php

session_start();
include('./config/db.php');

function redirectWithMessage($message)
{
    header('Location: index.php?message=' . urlencode($message));
    exit();
}

// Check if the user is logged in (adjust this based on your authentication logic)
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'][0];
    $userId = $user['user_id'];

    // Get product ID from the request
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$productId) {
        $message = "Product ID not provided";
        redirectWithMessage($message);
    }

    // Fetch the user's open cart
    $cartQuery = "SELECT * FROM carts WHERE user_id = $userId AND status = 'open'";
    $cartResult = mysqli_query($conn, $cartQuery);

    if (!$cartResult) {
        $message = "Error fetching user's cart: " . mysqli_error($conn);
        redirectWithMessage($message);
    }

    if (mysqli_num_rows($cartResult) > 0) {
        // User has an open cart
        $cart = mysqli_fetch_assoc($cartResult);
        $cartId = $cart['cart_id'];

        // Check if the item is in the cart
        $checkItemQuery = "SELECT ci.*, p.product_price FROM cart_items ci JOIN products p ON ci.product_id = p.product_id WHERE ci.cart_id = $cartId AND ci.product_id = $productId";
        $resultItem = mysqli_query($conn, $checkItemQuery);

        if (!$resultItem) {
            $message = "Error checking item in the cart: " . mysqli_error($conn);
            redirectWithMessage($message);
        }

        if (mysqli_num_rows($resultItem) > 0) {
            // Item is in the cart, fetch its details
            $cartItem = mysqli_fetch_assoc($resultItem);

            // Decrease quantity and update price in the cart
            $newQuantity = max(0, $cartItem['quantity'] - 1);
            $newPrice = $newQuantity * $cartItem['product_price'];

            $updateQuery = "UPDATE cart_items SET quantity = $newQuantity, price_paid = $newPrice WHERE cart_id = $cartId AND product_id = $productId";
            $resultUpdate = mysqli_query($conn, $updateQuery);

            if (!$resultUpdate) {
                $message = "Error updating quantity and price: " . mysqli_error($conn);
                redirectWithMessage($message);
            } else {
                // Check if quantity is zero, remove the item from the cart
                if ($newQuantity == 0) {
                    $removeItemQuery = "DELETE FROM cart_items WHERE cart_id = $cartId AND product_id = $productId";
                    $resultRemoveItem = mysqli_query($conn, $removeItemQuery);

                    if (!$resultRemoveItem) {
                        $message = "Error removing item from the cart: " . mysqli_error($conn);
                        redirectWithMessage($message);
                    } else {
                        $message = "Item removed from the cart successfully!";
                        redirectWithMessage($message);
                    }
                } else {
                    header('Location: cart.php');
                }
            }
        } else {
            $message = "Item not found in the cart";
            redirectWithMessage($message);
        }
    } else {
        $message = "You don't have an open cart.";
        redirectWithMessage($message);
    }
} else {
    $message = "User not logged in.";
    redirectWithMessage($message);
}
