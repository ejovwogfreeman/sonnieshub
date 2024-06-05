<?php

// Start session
// require_oncesession_start();

include('./partials/header.php');
// include('./config/db.php');
include('./utils/random_id.php');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
}


// Fetch products from the database
$sqlGroc = "SELECT * FROM products WHERE product_category = 'groceries'";
$result = mysqli_query($conn, $sqlGroc);
$productsGroc = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sqlHair = "SELECT * FROM products WHERE product_category = 'hair'";
$result = mysqli_query($conn, $sqlHair);
$productsHair = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <h4>Sonnies Hub</h4>
    <h2>One Stop Shop</h2>
    <h1>For Groceries</h1>
    <p>and Lush Extension Hairs</p>
    <button>Shop Now</button>
</section>

<!-- <section id="feature" class="section-p1">
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
</section> -->

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Shop Grocery Products At Affordable Prices</p>
    <div class="pro-container">
        <?php foreach ($productsGroc as $product) : ?>
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
                <a href=<?php echo "product/{$product['product_id']}" ?>><img src="<?php echo $img_src ?>" alt="" style='width: 100%; height: 300px; object-fit: contain'></a>
                <div class="des">
                    <span><?php echo $product['product_category']; ?></span>
                    <h5><?php echo $product['product_name']; ?></h5>
                    <p><?php echo $product['product_description'] ?></p>
                    <h4>£<?php echo $product['product_price']; ?></h4>
                </div>
                <a href=<?php echo "add_to_cart/{$product['product_id']}" ?>><i class="fas fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="banner" class="section-m1">
    <h4>Sonnie Travels</h4>
    <h2>Book your <span>Dream</span> - Vacation</h2>
    <button class="normal" onclick="window.location.replace(`http://localhost/sonnieshub/travels`)">Book Now</button>
</section>

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Buy Hair And Air Products</p>
    <div class="pro-container">
        <?php foreach ($productsHair as $product) : ?>
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
                <a href=<?php echo "product/{$product['product_id']}" ?>><img src="<?php echo $img_src ?>" alt="" style='width: 100%; height: 300px; object-fit: contain'></a>
                <div class="des">
                    <span><?php echo $product['product_category']; ?></span>
                    <h5><?php echo $product['product_name']; ?></h5>
                    <p><?php echo $product['product_description'] ?></p>
                    <h4>£<?php echo $product['product_price']; ?></h4>
                </div>
                <a href=<?php echo "add_to_cart/{$product['product_id']}" ?>><i class="fas fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="sm-banner" class="section-p1">
    <div class="banner-box">
        <h2>Lush Extension Hairs</h2>
        <button class="white" onclick="window.location.replace(`http://localhost/sonnieshub/shop?category=hair`)">Shop Now</button>
    </div>
    <div class="banner-box">
        <h2>Groceries</h2>
        <button class="white" onclick="window.location.replace(`http://localhost/sonnieshub/shop?category=groceries`)">Shop Now</button>
    </div>
</section>

<section id="banner3">
    <div class="banner-box">
        <!-- <h2>SEASONAL SALE</h2>
        <h3>Winter Collection -50% OFF</h3> -->
    </div>
    <div class="banner-box">
        <!-- <h2>NEW FOOTWEAR COLLECTION</h2>
        <h3>Spring / Summer 2023</h3> -->
    </div>
    <div class="banner-box">
        <!-- <h2>T-SHIRTS</h2>
        <h3>New Trendy Prints</h3> -->
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