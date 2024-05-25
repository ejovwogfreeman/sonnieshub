<?php

include('./config/session.php');
include('./config/db.php');
include('./utils/random_id.php');

function redirect()
{
    header('Location: /sonnieshub');
    exit();
}

// Check if the user is logged in (adjust this based on your authentication logic)
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
}

$productId = isset($_GET['id']) ? $_GET['id'] : null;

$randomId = generateRandomId();
$createdAt = date('Y-m-d H:i:s');

// Check if the user has an open cart
$checkCartQuery = "SELECT cart_id, status FROM carts WHERE user_id = '$userId' AND status = 'open'";
$resultCart = mysqli_query($conn, $checkCartQuery);

if (!$resultCart) {
    $_SESSION['msg'] =  "Error checking user's cart: " . mysqli_error($conn);
    redirect();
}

if (mysqli_num_rows($resultCart) == 0) {
    // If the user doesn't have an open cart, create a new one with status 'open' and current timestamp
    $createCartQuery = "INSERT INTO carts (cart_id, user_id, status, created_at) VALUES ('$randomId', '$userId', 'open', '$createdAt')";

    $resultCreateCart = mysqli_query($conn, $createCartQuery);

    if (!$resultCreateCart) {
        $_SESSION['msg'] =  "Error creating cart: " . mysqli_error($conn);
        redirect();
    }

    // // Get the newly created cart ID
    // $cartId = mysqli_insert_id($conn);

    // Get the newly created cart ID
    $selectCartIdQuery = "SELECT cart_id FROM carts WHERE user_id = '$userId' AND status = 'open' AND created_at = '$createdAt'";
    $resultSelectCartId = mysqli_query($conn, $selectCartIdQuery);

    if (!$resultSelectCartId) {
        $_SESSION['msg'] = "Error fetching cart ID: " . mysqli_error($conn);
        redirect();
    }

    $row = mysqli_fetch_assoc($resultSelectCartId);
    $cartId = $row['cart_id'];
} else {
    // If the user already has an open cart, get its ID
    $cartRow = mysqli_fetch_assoc($resultCart);
    $cartId = $cartRow['cart_id'];
}

// Fetch the product name based on product ID
// $fetchProductQuery = "SELECT product_name FROM products WHERE product_id = '$productId'";
$fetchProductQuery = "SELECT * FROM products WHERE product_id = '$productId'";
$resultProduct = mysqli_query($conn, $fetchProductQuery);

if (!$resultProduct) {
    $_SESSION['msg'] =  "Error fetching product details: " . mysqli_error($conn);
    redirect();
}

$productRow = mysqli_fetch_assoc($resultProduct);
$productName = $productRow['product_name'];

// Check if the item is already in the cart
$checkItemQuery = "SELECT * FROM cart_items WHERE cart_id = '$cartId' AND product_id = '$productId'";
$resultItem = mysqli_query($conn, $checkItemQuery);

if (!$resultItem) {
    $_SESSION['msg'] = "Error checking item in the cart: " . mysqli_error($conn);
    redirect();
}

$quantity = 1; // Set quantity to 1 by default

$pricePaid = $quantity * $productRow['product_price'];

if (mysqli_num_rows($resultItem) == 0) {
    // Item is not in the cart, add it
    $insertItemQuery = "INSERT INTO cart_items (cart_item_id, cart_id, product_id, product_name, quantity, price_paid) VALUES ('$randomId', '$cartId', '$productId', '$productName', '$quantity', '$pricePaid')";
    $resultInsertItem = mysqli_query($conn, $insertItemQuery);

    if ($resultInsertItem) {
        $_SESSION['msg'] = "Item added to the cart successfully!";
        redirect();
    } else {
        $_SESSION['msg'] = "Error adding item to the cart: " . mysqli_error($conn);
        redirect();
    }
} else {
    // Item is already in the cart, update quantity
    $_SESSION['msg'] = "Item already exist in the cart";
    redirect();
}
