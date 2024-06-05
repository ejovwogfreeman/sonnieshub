<?php

include('get_cart_items.php');
include('./partials/header.php');

function showFlyingAlert($message, $className)
{
    echo <<<EOT
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var alertDiv = document.createElement("div");
            alertDiv.className = "{$className}";
            alertDiv.innerHTML = "{$message}";
            document.body.appendChild(alertDiv);

            // Triggering reflow to enable animation
            alertDiv.offsetWidth;

            // Add a class to trigger the fly-in animation
            alertDiv.style.left = "10px";

            // Remove the fly-in style after 3 seconds
            setTimeout(function() {
                alertDiv.style.left = "10px";
            }, 2000);

            // Add a class to trigger the fly-out animation after 3 seconds
            setTimeout(function() {
                alertDiv.style.left = "-300px";
            }, 4000);

            // Remove the element after the total duration of the animation (9 seconds)
            setTimeout(function() {
                alertDiv.remove();
            }, 6000);
        });
    </script>
EOT;
}

if (isset($_SESSION['msg'])) {
    $message = $_SESSION['msg'];
    if (stristr($message, "successfully") || stristr($message, "Successfully") || stristr($message, "SUCCESSFUL")) {
        showFlyingAlert($message, "flying-success-alert");
        unset($_SESSION['msg']);
    } else {
        showFlyingAlert($message, "flying-danger-alert");
        unset($_SESSION['msg']);
    }
}

?>

<style>
    .flying-success-alert {
        position: fixed;
        z-index: 11111111111111;
        top: 15px;
        left: -300px;
        background-color: #088178;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        transition: left 1.5s ease-in-out;
    }

    .flying-danger-alert {
        position: fixed;
        z-index: 11111111111111;
        top: 15px;
        left: -300px;
        background-color: #FF5252;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        transition: left 1.5s ease-in-out;
    }
</style>

<section id="page-header" class="about-header">
    <h2>#cart</h2>
    <p>Add your coupon code & SAVE upto 70%!</p>
</section>

<section id="cart" class="section-p1">
    <?php if (!empty($products)) : ?>
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <?php
                        $imageData = $product['product_image'];
                        $imageInfo = getimagesizefromstring($imageData);

                        if ($imageInfo !== false) {
                            $imageFormat = $imageInfo['mime'];
                            $img_src = "data:$imageFormat;base64," . base64_encode($imageData);
                        } else {
                            echo "Unable to determine image type.";
                        }
                        ?>
                        <td>
                            <a href=<?php echo "remove_from_cart/{$product['product_id']}" ?> class="icon"><i class="fas fa-times-circle" style="color:black"></i></a>
                        </td>
                        <td><img src=<?php echo $img_src ?> alt=""></td>
                        <td><?php echo $product['product_name'] ?></td>
                        <td>$ <?php echo number_format($product['product_price']) ?></td>
                        <td>
                            <a href=<?php echo "decrease?id={$product['product_id']}" ?> class="icon"><i class="fas fa-minus-circle" style="color:black"></i></a>
                            <span><?php echo $product['quantity'] ?></span>
                            <a href=<?php echo "increase?id={$product['product_id']}" ?> class="icon"><i class="fas fa-plus-circle" style="color:black"></i></a>
                        </td>
                        <td>$ <?php echo number_format($product['quantity'] * $product['product_price']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No products found in the cart.</p>
    <?php endif ?>
</section>


<section id="cart-add" class="section-p1">
    <?php if (!empty($products)) : ?>
        <div class="subtotal">
            <h3>Cart Totals</h3>
            <table style="margin-bottom: 30px;">
                <tr>
                    <td>Total Items</td>
                    <td><?php echo $totalQuantity ?></td>
                </tr>
                <tr>
                    <td><strong>Total Price</strong></td>
                    <td><strong>$ <?php echo number_format($totalPrice) ?></strong></td>
                </tr>
            </table>
            <a class="checkout" href="checkout" class="normal">PROCEED TO CHECKOUT</a>
        </div>
    <?php endif; ?>
</section>

<?php

include('./partials/footer.php');

?>

<style>
    .checkout {
        background-color: #088178;
        color: #fff;
        text-decoration: none;
        padding: 12px 20px;
    }

    .icon {
        cursor: pointer;
        color: #088178;
        font-size: 18px;
    }
</style>