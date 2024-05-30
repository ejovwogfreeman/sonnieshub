<?php

// include('./config/session.php');
// include('./config/db.php');

// // Check if there are products in the cart
// $cartProducts = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// if (!empty($cartProducts)) {
//     $totalQuantity = 0;
//     $totalPrice = 0;

//     foreach ($cartProducts as $productId => $quantity) {
//         $totalQuantity += $quantity;

//         $sql = "SELECT * FROM products WHERE product_id = $productId";
//         $result = mysqli_query($conn, $sql);
//         $product = mysqli_fetch_assoc($result);

//         $totalPrice += $quantity * $product['product_price'];
//     }

//     // Fetch product details for the selected products
//     $productIds = array_keys($cartProducts);
//     $productIdsString = implode(',', $productIds);
//     $sql = "SELECT * FROM products WHERE product_id IN ($productIdsString)";
//     $result = mysqli_query($conn, $sql);
//     $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
// }


// // Check if a user is logged in
// if (isset($_SESSION['user'])) {
//     $user = $_SESSION['user'][0];
// }



// include('get_cart_items.php');

// $amount = $totalPrice;
// $first_name = $user['first_name'];
// $last_name = $user['last_name'];
// $email = $user['email'];

// // Create a unique transaction reference using the current timestamp
// $transaction_reference = time();

// $phoneNum = $_GET['phoneNum'];
// $shippingAddress = $_GET['shippingAddress'];

// // Prepare payment request data
// $request = array(
//     'tx_ref' => $transaction_reference,
//     'amount' => $amount,
//     'currency' => '$',
//     'payment_options' => 'card',
//     'redirect_url' => 'http://localhost/a2z_food/payment_status.php?phoneNum=' . urlencode($phoneNum) . '&shippingAddress=' . urlencode($shippingAddress),
//     'customer' => array(
//         'email' => $email,
//         'name' => $first_name . ' ' . $last_name,
//     ),
//     'meta' => array(
//         'price' => $amount,
//     ),
//     'customizations' => array(
//         'title' => 'Paying for a service',
//         'description' => 'Level',
//     ),
// );

// // Call Flutterwave endpoint
// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => json_encode($request),
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: FLWSECK_TEST-3336815230d55628321ee8dc58ca6195-X',
//         'Content-Type: application/json',
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);

// $res = json_decode($response, true);

// if ($res['status'] == 'success') {
//     // Payment was successful, redirect to the Flutterwave page
//     $link = $res['data']['link'];
//     header('Location: ' . $link);
// } else {
//     // Handle the case where the payment request was not successful
//     echo 'Error: ' . $res['message'];
// }


// // Call Paystack endpoint

// // Check if a user is logged in
// if (isset($_SESSION['user'])) {
//     $user = $_SESSION['user'][0];
// }

// include('get_cart_items.php');

// $amount = $totalPrice;
// $first_name = $user['first_name'];
// $last_name = $user['last_name'];
// $email = $user['email'];

// // Create a unique transaction reference using the current timestamp
// $transaction_reference = time();

// $request = array(
//     'tx_ref' => $transaction_reference,
//     'amount' => $amount * 100,
//     'currency' => '$',
//     'payment_options' => 'card',
//     'email' => $email,
//     // 'callback_url' => 'https://food.a2z.com.ng/payment_status.php?phoneNum=' . urlencode($phoneNum) . '&shippingAddress=' . urlencode($shippingAddress),
//     'callback_url' => 'https://food.a2z.com.ng/payment_status.php',
//     'customer' => array(
//         'email' => $email,
//         'name' => $first_name . ' ' . $last_name,
//     ),
// );

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://api.paystack.co/transaction/initialize',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => json_encode($request),
//     CURLOPT_HTTPHEADER => array(
// 'Authorization: Bearer sk_test_0b605bffd0593d738db87c543e46ab95183ae37d', // Correctly set the Authorization header
// 'Content-Type: application/json',
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);

// $res = json_decode($response, true);

// if ($res['status']) {
//     // Payment request was successful, redirect to the Paystack payment page
//     $authorization_url = $res['data']['authorization_url'];
//     header('Location: ' . $authorization_url);
// } else {
//     // Handle the case where the payment request was not successful
//     echo 'Error: ' . $res['message'];
// }

// Check if a user is logged in
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'][0];
}

include('get_cart_items.php');

$amount = $totalPrice;
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$email = $user['email'];

// Create a unique transaction reference using the current timestamp
$transaction_reference = time();

$phoneNum = $_GET['phoneNum'];
$shippingAddress = $_GET['shippingAddress'];

$url = "https://api.paystack.co/transaction/initialize";

$fields = [
    'email' => $email,
    'amount' => $amount * 100,
    'callback_url' => "http://localhost/a2z_food/payment_status.php?phoneNum=" . urlencode($phoneNum) . "&shippingAddress=" . urlencode($shippingAddress),
    'metadata' => ["cancel_action" => "http://localhost/a2z_food/checkout.php"]
];

$fields_string = json_encode($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    // 'Authorization: Bearer sk_test_0b605bffd0593d738db87c543e46ab95183ae37d', // Correctly set the Authorization header
    'Authorization: Bearer sk_live_247bc8ced8dbdeffc3172c5f9f8b89b0f00c601b',
    'Content-Type: application/json',
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    // Handle the error appropriately
} else {
    // Decode the JSON response
    $response = json_decode($res, true);

    // Check if decoding was successful
    if ($response !== null) {
        if ($response['status']) {
            // Payment request was successful, redirect to the Paystack payment page
            $authorization_url = $response['data']['authorization_url'];
            header('Location: ' . $authorization_url);
        } else {
            // Handle the case where the payment request was not successful
            echo 'Error: ' . $response['message'];
        }
    } else {
        // Handle JSON decoding error
        echo 'Error decoding JSON response from Paystack';
    }
}

curl_close($ch);
