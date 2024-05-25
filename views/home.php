<?php

include('./partials/header.php');
include('./config/session.php'); // Ensure this includes session_start()
include('./config/db.php');
include('./utils/random_id.php');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'][0];
    $userId = $user['user_id'];
}


// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

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

<section id="hero">
    <h4>Trade-in-offer</h4>
    <h2>Super value deals</h2>
    <h1>On all products</h1>
    <p>Save more with coupons & up to 70% off!</p>
    <button>Shop Now</button>
</section>

<section id="feature" class="section-p1">
    <div class="fe-box">
        <img src="images/features/f1.png" alt="">
        <h6>Free Shipping</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f2.png" alt="">
        <h6>Online Order</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f3.png" alt="">
        <h6>Save Money</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f4.png" alt="">
        <h6>Promotions</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f5.png" alt="">
        <h6>Happy Sell</h6>
    </div>
    <div class="fe-box">
        <img src="images/features/f6.png" alt="">
        <h6>F24/7 Support</h6>
    </div>
</section>

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
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
                <a href=<?php echo "add_to_cart?id={$product['product_id']}" ?>><i class="fas fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="banner" class="section-m1">
    <h4>Repair Services</h4>
    <h2>Up to <span>70% Off</span> - All t-Shirts & Accessories</h2>
    <button class="normal">Explore More</button>
</section>

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
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
                <a href=<?php echo "add_to_cart?id={$product['product_id']}" ?>><i class="fas fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="sm-banner" class="section-p1">
    <div class="banner-box">
        <h4>crazy deals</h4>
        <h2>buy 1 get 1 free</h2>
        <span>The best classic dress is on sale at cara</span>
        <button class="white">Learn more</button>
    </div>
    <div class="banner-box">
        <h4>spring/summer</h4>
        <h2>upcoming season</h2>
        <span>The best classic dress is on sale at cara</span>
        <button class="white">Collection</button>
    </div>
</section>

<section id="banner3">
    <div class="banner-box">
        <h2>SEASONAL SALE</h2>
        <h3>Winter Collection -50% OFF</h3>
    </div>
    <div class="banner-box">
        <h2>NEW FOOTWEAR COLLECTION</h2>
        <h3>Spring / Summer 2023</h3>
    </div>
    <div class="banner-box">
        <h2>T-SHIRTS</h2>
        <h3>New Trendy Prints</h3>
    </div>
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