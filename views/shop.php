<?php

include('./partials/header.php');
include('./config/db.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<section id="page-header">
    <h2>#stayhome</h2>
    <p>Save more with coupons & up to 70% off!</p>
</section>

<section id="product1" class="section-p1">
    <div class="shop-topbar">
        <h2>All Products</h2>
        <form>
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                <path fill="currentColor" d="M19.5 3C14.265 3 10 7.265 10 12.5c0 2.25.81 4.307 2.125 5.938L3.28 27.28l1.44 1.44l8.843-8.845C15.192 21.19 17.25 22 19.5 22c5.235 0 9.5-4.265 9.5-9.5S24.735 3 19.5 3m0 2c4.154 0 7.5 3.346 7.5 7.5S23.654 20 19.5 20S12 16.654 12 12.5S15.346 5 19.5 5" />
            </svg>
            <input type="text">
            <button>Search</button>
        </form>
    </div>
    <div class="pro-container">
        <?php foreach ($products as $product) : ?>
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
                <img src="<?php echo $img_src ?>" alt="">
                <div class="des">
                    <span><?php echo $product['product_category']; ?></span>
                    <h5><?php echo $product['product_name']; ?></h5>
                    <p><?php echo $product['product_description'] ?></p>
                    <h4>$<?php echo $product['product_price']; ?></h4>
                </div>
                <span onclick="addToCart('<?php echo $product['product_id']; ?>')"><i class="fas fa-shopping-cart cart"></i></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="pagination" class="section-p1">
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#"><i class="fas fa-long-arrow-alt-right"></i></a>
</section>

<section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Sign Up For Newsletter</h4>
        <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
    </div>
    <div class="form">
        <input type="text" placeholder="Your email address">
        <button class="normal">Sign Up</button>
    </div>
</section>

<?php

include('./partials/footer.php');

?>

<style>
    .shop-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between
    }

    .shop-topbar form {
        color: #088178;
        display: block;
        padding: 3px 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .shop-topbar input {
        width: 100%;
        font-size: 18px;
        border: none;
        outline: none;
        color: #088178;
    }

    .shop-topbar button {
        font-size: 18px;
        padding: 5px;
        border-radius: 3px;
        background-color: #088178;
        border: 1px solid #088178;
        color: #fff;
        cursor: pointer;
    }
</style>