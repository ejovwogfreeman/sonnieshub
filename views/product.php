<?php

include('./partials/header.php');
require_once('./config/db.php');

if (isset($productId)) {
    // Fetch order details
    $sqlProduct = "SELECT * FROM products WHERE product_id = '$productId'";
    $resultProduct = mysqli_query($conn, $sqlProduct);
    $product = mysqli_fetch_assoc($resultProduct);
}

$productCategory = $product['product_category'];

$sqlCat = "SELECT * FROM products WHERE product_category = '$productCategory'";
$result = mysqli_query($conn, $sqlCat);
$productsCat = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<section id="productdetails" class="section-p1">
    <div class="single-pro-image">
        <!-- Make sure to use the correct column name for the image path -->
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
        <img src="<?php echo $img_src ?>" width="100%" id="MainImg" alt="">
    </div>
    <div class="single-pro-details" style="padding-top: 0px">
        <h4> <?php echo $product['product_name'] ?></h4>
        <span style="background-color: #088178; color: white; padding: 5px; border-radius: 3px; font-size: 12px;"><?php echo $product['product_category'] ?></span>
        <h2>£ <?php echo $product['product_price'] ?></h2>
        <a href=<?php echo "http://localhost/sonnieshub/add_to_cart/{$product['product_id']}" ?> style='background-color:#088178; border-radius: 3px; padding: 8px 6px; text-decoration: none; color: white'>Add To Cart</a>
        <h4>Product Details</h4>
        <span><?php echo $product['product_description'] ?></span>
    </div>
</section>

<section id="product1" class="section-p1">
    <h2>Similar Procuts</h2>
    <p>Shop Similar Products Under <?php echo ucfirst($productCategory) ?></p>
    <div class="pro-container">
        <?php foreach ($productsCat as $product) : ?>
            <div class="pro">
                <!-- Make sure to use the correct column name for the image path -->
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
                <img src="<?php echo $img_src ?>" alt="" style='width: 100%; height: 300px; object-fit: contain'>
                <div class="des">
                    <span><?php echo $product['product_category']; ?></span>
                    <h5><?php echo $product['product_name']; ?></h5>
                    <p><?php echo $product['product_description'] ?></p>
                    <h4>$<?php echo $product['product_price']; ?></h4>
                </div>
                <a href=<?php echo "http://localhost/sonnieshub/add_to_cart/{$product['product_id']}" ?>><i class="fas fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Sign Up For Newsletter</h4>
        <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
    </div>
    <div class="form">
        <input type="text" placeholder="Your email address">
        <button class="normal">Sign Up</button>
    </div>
</section> -->

<?php

include('./partials/footer.php');

?>