<?php

// include('./config/session.php');
// include('./config/db.php');
ob_start();
include('get_cart_items.php');
include('./partials/header.php');

// Check if a user is logged in
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

// $cartProducts = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$phoneNum = $shippingAddress  =  $Err = '';
$counter = 1;

// if (!empty($cartProducts)) {
//     $totalQuantity = 0;
//     $totalPrice = 0;
//     $counter = 1;

//     foreach ($cartProducts as $productId => $quantity) {
//         $totalQuantity += $quantity;

//         $sql = "SELECT * FROM products WHERE product_id = $productId";
//         $result = mysqli_query($conn, $sql);
//         $product = mysqli_fetch_assoc($result);

//         $totalPrice += $quantity * $product['product_price'];
//     }

//     $productIds = array_keys($cartProducts);
//     $productIdsString = implode(',', $productIds);
//     $sql = "SELECT * FROM products WHERE product_id IN ($productIdsString)";
//     $result = mysqli_query($conn, $sql);
//     $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// include()


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['phoneNum'])) {
        $Err = 'PLEASE ENTER A PHONE NUMBER';
    } else {
        $phoneNum = htmlspecialchars($_POST['phoneNum']);
        if (empty($_POST['shippingAddress'])) {
            $Err = 'PLEASE ENTER A SHIPPING ADDRESS';
        } else {
            $shippingAddress = htmlspecialchars($_POST['shippingAddress']);
            header("Location: process_payment.php?phoneNum=" . urlencode($phoneNum) . "&shippingAddress=" . urlencode($shippingAddress));
        }
    }
}

$email = '';

ob_end_flush();

?>

<section id="page-header" class="about-header">
    <h2>#checkout</h2>
    <p>Add your coupon code & SAVE upto 70%!</p>
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
        <?php echo isset($err) ? "<div class='error'>" . $err . "</div>" : ""; ?>
        <div class="input-container">
            <label for="email" class="form-label" placeholder="Enter email">Phone Number</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="<?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['email']) ? "<div class='invalid-feedback'>" . $errors['email'] . "</div>" : ""; ?>
        </div>
        <div class="input-container">
            <label for="email" class="form-label" placeholder="Enter email">Address/Location</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="<?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['email']) ? "<div class='invalid-feedback'>" . $errors['email'] . "</div>" : ""; ?>
        </div>
        <div>
            <button class="btn" type="submit">CHECKOUT</button>
        </div>
    </form>
    <div class="div">
        <section id="cart" class="section-p1">
            <?php if (!empty($products)) : ?>
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
                                    <td><?php echo $product['product_name'] ?></td>
                                    <td>$ <?php echo number_format($product['product_price']) ?></td>
                                    <td>
                                        <span><?php echo $product['quantity'] ?></span>
                                    </td>
                                    <td>$ <?php echo number_format($product['quantity'] * $product['product_price']) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No products found in the cart.</p>
                <?php endif ?>
                <div class="subtotal" style="margin-top: 30px">
                    <h3>Cart Totals</h3>
                    <table>
                        <tr>
                            <td>Total Items</td>
                            <td><?php echo $totalQuantity ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Price</strong></td>
                            <td><strong>$ <?php echo number_format($totalPrice) ?></strong></td>
                        </tr>
                    </table>
                    <button class="normal">PROCEED TO CHECKOUT</button>
                </div>
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
        /* Light green box shadow on focus */
        outline: none;
    }

    input[type="text"].is-invalid,
    input[type="email"].is-invalid,
    input[type="password"].is-invalid {
        margin-top: 10px;
        border-color: red;
        box-shadow: 0px 0px 5px rgba(255, 0, 0, 0.5);
        /* Light red box shadow on error */
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

    .success-message {
        color: #088178;
        margin-top: 20px;
    }

    .error-message {
        color: red;
        margin-top: 20px;
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

    .bottom-box {
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .bottom-box p,
    .bottom-box a {
        font-size: 14px;
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