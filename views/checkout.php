<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('get_cart_items.php'); // Assume this file sets $products, $totalQuantity, $totalPrice
include('./partials/header.php');
require_once('./config/db.php'); // Database connection
include('./utils/random_id.php');

function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

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

    if (empty($errors)) {
        // Proceed with the order processing
        $user = $_SESSION['user'];
        $userId = $user['user_id'];
        $orderId = generateRandomId();
        $dateOrdered = date('Y-m-d H:i:s');

        // Create a new order
        $createOrderQuery = "INSERT INTO orders (order_id, user_id, phone_number, shipping_address, total_price, status, date_ordered) VALUES ('$orderId', '$userId', '$phoneNum', '$shippingAddress', $totalPrice, 'pending', '$dateOrdered')";
        $resultCreateOrder = mysqli_query($conn, $createOrderQuery);

        if (!$resultCreateOrder) {
            $_SESSION['msg'] = "Error creating order: " . mysqli_error($conn);
            redirect('/sonnieshub/checkout');
        }

        // Insert items from the cart into the order_items table
        foreach ($products as $singleProduct) {
            $orderItemsId = generateRandomId();
            $productId = $singleProduct['product_id'];
            $productName = $singleProduct['product_name'];
            $quantity = $singleProduct['quantity'];
            $pricePaid = $singleProduct['price_paid'];

            $sqlOrderItem = "INSERT INTO order_items (order_item_id, order_id, product_id, product_name, quantity, price_paid) VALUES ('$orderItemsId', '$orderId', '$productId', '$productName', '$quantity', '$pricePaid')";
            if (!mysqli_query($conn, $sqlOrderItem)) {
                $_SESSION['msg'] = "Error inserting order item: " . mysqli_error($conn);
                redirect('/sonnieshub/checkout');
            }
        }

        // Update the cart status to 'closed'
        $cartQuery = "SELECT cart_id FROM carts WHERE user_id = '$userId' AND status = 'open'";
        $cartResult = mysqli_query($conn, $cartQuery);

        if ($cartResult && mysqli_num_rows($cartResult) > 0) {
            $cart = mysqli_fetch_assoc($cartResult);
            $cartId = $cart['cart_id'];

            if (mysqli_query($conn, "UPDATE carts SET status = 'closed' WHERE cart_id = '$cartId'")) {
                // Store total items and total price in session
                $_SESSION['totalItems'] = $totalQuantity;
                $_SESSION['totalPrice'] = $totalPrice;

                // Redirect to the payment page
                redirect('/sonnieshub/payment');
            } else {
                $errors['database'] = "Error updating cart status.";
            }
        } else {
            $errors['cart'] = "You don't have an open cart.";
        }
    }
}

ob_end_flush();

?>

<section id="page-header" class="about-header">
    <h2>#checkout</h2>
    <p>Add your coupon code & SAVE up to 70%!</p>
</section>

<div class="flex-container">
    <a href="cart" style="font-size: 30px; color:#088178;"><i class="fa fa-arrow-circle-left"></i></a>
    <h3 class="m-0">Proceed To Checkout</h3>
</div>

<section id="cart-add" class="section-p1 checkout-container">
    <form id="auth-form" method="POST">
        <div style="text-align: center; margin-bottom: 30px">
            <h3 style="color:#088178">ENTER YOUR SHIPPING ADDRESS</h3>
        </div>
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='success-msg'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']); // Clear the message after displaying it
        }
        ?>
        <div class="input-container">
            <label for="phoneNum" class="form-label">Phone Number</label>
            <input type="text" id="phoneNum" name="phoneNum" value="<?php echo htmlspecialchars($phoneNum); ?>" class="<?php echo isset($errors['phoneNum']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['phoneNum']) ? "<div class='invalid-feedback'>" . $errors['phoneNum'] . "</div>" : ""; ?>
        </div>
        <div class="input-container">
            <label for="shippingAddress" class="form-label">Address/Location</label>
            <input type="text" id="shippingAddress" name="shippingAddress" value="<?php echo htmlspecialchars($shippingAddress); ?>" class="<?php echo isset($errors['shippingAddress']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['shippingAddress']) ? "<div class='invalid-feedback'>" . $errors['shippingAddress'] . "</div>" : ""; ?>
        </div>
        <div>
            <button class="btn" type="submit">CHECKOUT</button>
        </div>
    </form>
    <div class="div">
        <section id="cart" class="section-p1">
            <?php if (!empty($products)) : ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_name']) ?></td>
                                <td>$ <?php echo number_format($product['product_price'], 2) ?></td>
                                <td>
                                    <span><?php echo $product['quantity'] ?></span>
                                </td>
                                <td>$ <?php echo number_format($product['quantity'] * $product['product_price'], 2) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <div class="subtotal" style="margin-top: 30px">
                    <h3>Cart Totals</h3>
                    <table>
                        <tr>
                            <td>Total Items</td>
                            <td><?php echo $totalQuantity ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Price</strong></td>
                            <td><strong>$ <?php echo number_format($totalPrice, 2) ?></strong></td>
                        </tr>
                    </table>
                </div>
            <?php else : ?>
                <p>No products found in the cart.</p>
            <?php endif; ?>
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
</style>