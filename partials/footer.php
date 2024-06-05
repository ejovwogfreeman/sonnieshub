<footer class="section-p1">
    <div class="col">
        <?php
        if (strpos($url, 'admin') !== false) {
            echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
        } else {
            if (preg_match($pattern, $url)) {
                echo '<a href="/sonnieshub"><img src="/images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } elseif (strpos($url, 'order_details') !== false) {
                echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } else {
                echo '<a href="/sonnieshub"><img src="images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            }
        }
        ?>
        <h4>Contact</h4>
        <p><strong>Address:</strong> Lahore, Pakistan - 54840</p>
        <p><strong>Phone:</strong> +92-321-4655990</p>
        <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
        <div class="follow">
            <h4>Follow us</h4>
            <div class="icon">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-pinterest-p"></i>
                <i class="fab fa-youtube"></i>
            </div>
        </div>
    </div>
    <div class="col">
        <h4>About</h4>
        <a href="#">About us</a>
        <a href="#">Delivery Information</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
        <a href="#">Contact Us</a>
    </div>
    <div class="col">
        <h4>My Account</h4>
        <a href="#">Sign In</a>
        <a href="#">View Cart</a>
        <a href="#">My Wishlist</a>
        <a href="#">Track My Order</a>
        <a href="#">Help</a>
    </div>
    <div class="copyright">
        <p>SonniesHub | All Rights Reserved | &#169; 2023</p>
    </div>
</footer>

<?php
// Check if 'admin' is in the URL
if (strpos($url, 'admin') !== false) {
    echo '<script src="../js/script.js"></script>';
} else {
    echo '<script src="js/script.js"></script>';
}
?>
</body>

</html>