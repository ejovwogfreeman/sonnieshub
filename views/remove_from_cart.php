<?php

session_start(); // Ensure session is started
include('./config/db.php');

// Function to redirect to cart page
function redirect()
{
    header('Location: cart'); // Adjust redirect location as needed
    exit();
}

// Check if the user is logged in (adjust this based on your authentication logic)
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
} else {
    $_SESSION['msg'] = "User not logged in";
    redirect();
}

$productId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$productId) {
    $_SESSION['msg'] = "Product ID not provided";
    redirect();
}

// Check if the user has an open cart
$checkCartQuery = "SELECT cart_id FROM carts WHERE user_id = '$userId' AND status = 'open'";
$resultCart = mysqli_query($conn, $checkCartQuery);

if (!$resultCart) {
    $_SESSION['msg'] = "Error checking user's cart: " . mysqli_error($conn);
    redirect();
}

if (mysqli_num_rows($resultCart) > 0) {
    // User has an open cart, get its ID
    $cartRow = mysqli_fetch_assoc($resultCart);
    $cartId = $cartRow['cart_id'];

    // Check if the item is in the cart
    $checkItemQuery = "SELECT * FROM cart_items WHERE cart_id = '$cartId' AND product_id = '$productId'";
    $resultItem = mysqli_query($conn, $checkItemQuery);

    if (!$resultItem) {
        $_SESSION['msg'] = "Error checking item in the cart: " . mysqli_error($conn);
        redirect();
    }

    if (mysqli_num_rows($resultItem) > 0) {
        // Item is in the cart, remove it
        $removeItemQuery = "DELETE FROM cart_items WHERE cart_id = '$cartId' AND product_id = '$productId'";
        $resultRemoveItem = mysqli_query($conn, $removeItemQuery);

        if ($resultRemoveItem) {
            $_SESSION['msg'] = "Item removed from the cart successfully!";
            redirect();
        } else {
            $_SESSION['msg'] = "Error removing item from the cart: " . mysqli_error($conn);
            redirect();
        }
    } else {
        $_SESSION['msg'] = "Item not found in the cart";
        redirect();
    }
} else {
    $_SESSION['msg'] = "User does not have an open cart";
    redirect();
}
