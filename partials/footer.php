<footer class="section-p1">
    <div class="col">
        <?php
        if (strpos($url, 'admin') !== false) {
            echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
        } else {
            if (preg_match($pattern, $url)) {
                echo '<a href="/sonnieshub"><img src="/images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } elseif (strpos($url, 'order_details') !== false) {
                echo '<a href="/sonnieshub"><img src="/images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } elseif (strpos($url, 'user_profile') !== false) {
                echo '<a href="/sonnieshub"><img src="/images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } elseif (strpos($url, 'blog') !== false) {
                echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } elseif (strpos($url, 'product') !== false) {
                echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } else {
                echo '<a href="/sonnieshub"><img src="images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            }
        }
        ?>
        <h4>Contact</h4>
        <p><strong>Phone:</strong> +447776971422</p>
        <p><strong>Email:</strong> <a href="mailto:sonnietravels24@gmail.com">Sonnietravels24@gmail.com</a></p>
        <div class="follow">
            <h4>Follow us</h4>
            <div class="icon">
                <a href="https://web.facebook.com/chysom24" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M15.725 22v-7.745h2.6l.389-3.018h-2.99V9.31c0-.874.243-1.47 1.497-1.47h1.598v-2.7a21.391 21.391 0 0 0-2.33-.12c-2.304 0-3.881 1.407-3.881 3.99v2.227H10v3.018h2.607V22H3.104C2.494 22 2 21.506 2 20.896V3.104C2 2.494 2.494 2 3.104 2h17.792C21.506 2 22 2.494 22 3.104v17.792c0 .61-.494 1.104-1.104 1.104z" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/sonnietravels24" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                    </svg>
                </a>
                <a href="https://www.tiktok.com/@sommie51" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="col">
        <h4>About</h4>
        <a href="about">About us</a>
        <a href="contact">Contact Us</a>
        <a href="articles">Blogs</a>
    </div>
    <div class="col">
        <h4>My Account</h4>
        <a href="register">Sign Up</a>
        <a href="login">Sign In</a>
        <a href="cart">View Cart</a>
    </div>
    <div class="copyright">
        <p>SonniesHub | All Rights Reserved | &#169; <?php echo date('Y') ?></p>
    </div>
</footer>

<?php
// Check if 'admin' is in the URL
if (strpos($url, 'admin') !== false) {
    echo '<script src="../js/script.js"></script>';
} else {
    if (preg_match($pattern, $url)) {
        echo '<script src="/js/script.js"></script>';
    } elseif (strpos($url, 'order_details') !== false) {
        echo '<script src="/js/script.js"></script>';
    } elseif (strpos($url, 'user_profile') !== false) {
        echo '<script src="/js/script.js"></script>';
    } elseif (strpos($url, 'blog') !== false) {
        echo '<script src="../js/script.js"></script>';
    } elseif (strpos($url, 'product') !== false) {
        echo '<script src="../js/script.js"></script>';
    } else {
        echo '<script src="js/script.js"></script>';
    }
}
?>
</body>

</html>