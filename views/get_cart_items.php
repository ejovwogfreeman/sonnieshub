<?php
// include('./config/session.php');
// include('./config/db.php');

// // Check if the user is logged in (adjust this based on your authentication logic)
// if (isset($_SESSION['user'])) {
//     $user = $_SESSION['user'][0];
//     $userId = $user['user_id'];

//     // Fetch the user's open cart
//     $cartQuery = "SELECT * FROM carts WHERE user_id = $userId AND status = 'open'";
//     $cartResult = mysqli_query($conn, $cartQuery);

//     if (!$cartResult) {
//         die("Error fetching user's cart: " . mysqli_error($conn));
//     }

//     if (mysqli_num_rows($cartResult) > 0) {
//         // User has an open cart
//         $cart = mysqli_fetch_assoc($cartResult);
//         $cartId = $cart['cart_id'];

//         // Fetch cart items from the database
//         $cartItemsQuery = "SELECT ci.*, p.* FROM cart_items ci JOIN products p ON ci.product_id = p.product_id WHERE ci.cart_id = $cartId";
//         $cartItemsResult = mysqli_query($conn, $cartItemsQuery);

//         if (!$cartItemsResult) {
//             die("Error fetching cart items: " . mysqli_error($conn));
//         }

//         $products = mysqli_fetch_all($cartItemsResult, MYSQLI_ASSOC);

//         $totalQuantity = 0;
//         $totalPrice = 0; // Initialize total price
//         $uniqueProductIds = [];

//         foreach ($products as $cartItem) {
//             $productId = $cartItem['product_id'];

//             // Check if the product ID is already in the list of unique IDs
//             if (!in_array($productId, $uniqueProductIds)) {
//                 $uniqueProductIds[] = $productId; // Add the product ID to the list
//                 $totalQuantity += $cartItem['quantity'];
//                 $totalPrice += $cartItem['quantity'] * $cartItem['product_price'];
//             }
//         }
//     } else {
//         // echo "You don't have an open cart.";
//     }
// } else {
//     // echo "User not logged in.";
// }

session_start(); // Ensure session is started
include('./config/db.php');

if (!isset($_SESSION['user'])) {
    die("User not logged in");
}

$user = $_SESSION['user'];
$userId = $user['user_id'];

$cartQuery = "SELECT c.cart_id FROM carts c WHERE c.user_id = '$userId' AND c.status = 'open' LIMIT 1";
$resultCart = mysqli_query($conn, $cartQuery);

if (!$resultCart) {
    die("Error retrieving cart: " . mysqli_error($conn));
} else {
}

if (mysqli_num_rows($resultCart) > 0) {
    $cart = mysqli_fetch_assoc($resultCart);
    $cartId = $cart['cart_id'];

    $cartItemsQuery = "
        SELECT ci.*, p.product_name, p.product_price, p.product_image
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        WHERE ci.cart_id = '$cartId'
    ";
    $resultItems = mysqli_query($conn, $cartItemsQuery);

    if (!$resultItems) {
        die("Error retrieving cart items: " . mysqli_error($conn));
    }

    $products = mysqli_fetch_all($resultItems, MYSQLI_ASSOC);

    $totalQuantity = 0;
    $totalPrice = 0; // Initialize total price
    $uniqueProductIds = [];

    foreach ($products as $cartItem) {
        $productId = $cartItem['product_id'];

        // Check if the product ID is already in the list of unique IDs
        if (!in_array($productId, $uniqueProductIds)) {
            $uniqueProductIds[] = $productId; // Add the product ID to the list
            $totalQuantity += $cartItem['quantity'];
            $totalPrice += $cartItem['quantity'] * $cartItem['product_price'];
        }
    }
}
