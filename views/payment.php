<?php

// Check if a session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();
include('get_cart_items.php'); // Assume this file sets $products, $totalQuantity, $totalPrice
include('./partials/header.php');
require_once('./config/db.php'); // Database connection

$errors = [];
$phoneNum = $shippingAddress = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate phone number
    if (empty($_POST['phoneNum'])) {
        $errors['phoneNum'] = 'Phone number is required.';
    } else {
        $phoneNum = htmlspecialchars($_POST['phoneNum']);
    }

    // Validate shipping address
    if (empty($_POST['shippingAddress'])) {
        $errors['shippingAddress'] = 'Shipping address is required.';
    } else {
        $shippingAddress = htmlspecialchars($_POST['shippingAddress']);
    }

    // If no errors, proceed to add order and order items
    if (empty($errors)) {
        $userId = $_SESSION['user']['user_id'];
        $totalPrice = array_reduce($products, function ($carry, $product) {
            return $carry + ($product['product_price'] * $product['quantity']);
        }, 0);

        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Insert into orders table
            $insertOrderQuery = "INSERT INTO orders (user_id, phone_number, shipping_address, total_price) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($stmt, "isss", $userId, $phoneNum, $shippingAddress, $totalPrice);
            mysqli_stmt_execute($stmt);
            $orderId = mysqli_insert_id($conn);

            // Insert into order_items table
            foreach ($products as $product) {
                $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertOrderItemQuery);
                mysqli_stmt_bind_param($stmt, "iiid", $orderId, $product['product_id'], $product['quantity'], $product['product_price']);
                mysqli_stmt_execute($stmt);
            }

            // Commit transaction
            mysqli_commit($conn);

            $_SESSION['msg'] = 'Order placed successfully';
            header('Location: confirmation_page.php');
            exit();
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            $errors['general'] = 'Failed to place order. Please try again.';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($conn);
}

$totalItems = isset($_SESSION['totalItems']) ? $_SESSION['totalItems'] : 0;
$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;

ob_end_flush();


?>

<section id="page-header" class="about-header">
    <h2>#checkout</h2>
    <p>Add your coupon code & SAVE up to 70%!</p>
</section>

<div class="flex-container">
    <a href="/sonnieshub/checkout" style="font-size: 30px; color:#088178;"><i class="fa fa-arrow-circle-left"></i></a>
    <h3 class="m-0"></h3>
</div>

<section id="cart-add" class="section-p1 checkout-container">
    <div class="div">
        <section id="cart" class="section-p1">
            <div class="subtotal" style="margin: auto; margin-top: 30px">
                <h3>Cart Totals</h3>
                <table>
                    <tr>
                        <td>Total Items</td>
                        <td><?php echo $totalItems ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Price</strong></td>
                        <td><strong>$ <?php echo number_format($totalPrice, 2) ?></strong></td>
                    </tr>
                </table>
                <a href="https://api.whatsapp.com/send?phone=447776971422&text=Hello!%20I%20just%20placed%20an%20order%20and%20I%20want%20to%20make%20payment%20" target="_blank" class="paypal-link">
                    <img src="images/paypal.png" alt="" class="paypal">
                </a>
            </div>
        </section>
    </div>
</section>

<?php include('./partials/footer.php'); ?>

<style>
    .flex-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 40px 80px;
    }

    #auth-form {
        padding: 50px 30px 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #fff;
    }

    .input-container {
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 18px;
        color: #088178;
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        color: #088178;
        font-size: 18px;
        display: block;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #088178;
        box-shadow: 0px 0px 5px rgba(8, 129, 120, 0.5);
        outline: none;
    }

    input[type="text"].is-invalid,
    input[type="email"].is-invalid,
    input[type="password"].is-invalid {
        margin-top: 10px;
        border-color: red;
        box-shadow: 0px 0px 5px rgba(255, 0, 0, 0.5);
    }

    .invalid-feedback {
        margin-top: 10px;
        color: red;
        font-size: 14px;
    }

    .success-msg {
        padding: 15px;
        margin-bottom: 20px;
        color: #0f5132;
        background-color: #d1e7dd;
        border: 1px solid #badbcc;
        border-radius: 3px;
    }

    .btn {
        background-color: #088178;
        border: 1px solid #088178;
        color: #fff;
        padding: 10px;
        width: 100%;
        font-size: 18px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #06695a;
        border-color: #06695a;
    }

    .checkout-container {
        display: flex;
        align-items: center;
    }

    .checkout-container form {
        flex: 1;
    }

    .checkout-container .div {
        flex: 2;
    }

    @media (max-width: 799px) {
        #auth-form {
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 50px 30px 50px;
            width: 90%;
        }
    }

    @media (max-width: 477px) {
        .bottom-box {
            margin-top: 30px;
            display: block;
            align-items: center;
            justify-content: space-between;
            font-size: 16px;
        }

        #auth-form {
            padding: 50px 20px 50px;
        }
    }

    .paypal-link {
        width: 100%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        display: block;
        text-align: center;
        padding: 20px 0px 10px;
        border-radius: 3px;
    }

    .paypal {
        margin: auto;
        width: 150px;
    }
</style>