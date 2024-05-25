<?php
include('./partials/header.php');
include('./config/db.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

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
    <!-- Add more feature boxes as needed -->
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
                <span onclick="addToCart('<?php echo $product['product_id']; ?>')"><i class="fas fa-shopping-cart cart"></i></span>
            </div>
        <?php endforeach; ?>
        <button onclick="addToCart('bmun95HTD4t6nOCW82gZ1Sm0S9Xv7F')">Add to Cart</button>
    </div>
</section>

<section id="banner" class="section-m1">
    <!-- Add banners as needed -->
</section>

<section id="product2" class="section-p1">
    <!-- Add more product sections as needed -->
</section>

<section id="newsletter" class="section-p1 section-m1">
    <!-- Add newsletter section as needed -->
</section>

<?php
mysqli_close($conn);
include('./partials/footer.php');
?>

<script>
    // async function addToCart(productId) {
    //     const data = {
    //         action: 'add',
    //         product_id: productId,
    //         quantity: 1 // Default quantity to add
    //     };

    //     console.log('Sending data:', data);

    //     try {
    //         const response = await fetch('http://localhost/sonnieshub/cart_endpoints', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify(data)
    //         });

    //         console.log('Response:', response);

    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }

    //         const responseData = await response.json();
    //         console.log('Response data:', responseData);

    //         if (responseData.success) {
    //             alert('Product added to cart');
    //         } else {
    //             alert('Failed to add product to cart: ' + responseData.message);
    //         }
    //     } catch (error) {
    //         console.error('Error:', error);
    //         // alert('An error occurred while adding the product to cart');
    //     }
    // }

    async function addToCart(productId) {
        const data = {
            action: 'add',
            product_id: productId,
            quantity: 1 // Default quantity to add
        };

        try {
            const response = await fetch('http://localhost/sonnieshub/cart_endpoints', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const jsonData = await response.json();

            console.log(jsonData)

            // if (jsonData.success) {
            //     console.log('Product added to cart');
            // } else {
            //     console.log('Failed to add product to cart: ' + jsonData.message);
            // }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>