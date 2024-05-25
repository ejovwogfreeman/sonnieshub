<?php

include('get_cart_items.php');
include('./partials/header.php');

?>

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
                            <span class="icon"><i class="fas fa-times-circle" style="color:black"></i></span>
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
            <button class="normal">Proceed to checkout</button>
        </div>
    <?php endif; ?>
</section>

<?php

include('./partials/footer.php');

?>

<style>
    .icon {
        cursor: pointer;
        color: #088178;
        font-size: 18px;
    }
</style>