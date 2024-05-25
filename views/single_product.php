<?php

include('./partials/header.php');

?>

<section id="productdetails" class="section-p1">
    <div class="single-pro-image">
        <img src="images/products/f1.jpg" width="100%" id="MainImg" alt="">
        <div class="small-image-group">
            <div class="small-img-col">
                <img src="images/products/f1.jpg" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="images/products/f2.jpg" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="images/products/f3.jpg" width="100%" class="small-img" alt="">
            </div>
            <div class="small-img-col">
                <img src="images/products/f4.jpg" width="100%" class="small-img" alt="">
            </div>
        </div>
    </div>
    <div class="single-pro-details">
        <h6>Home / T-Shirt</h6>
        <h4>Men's Fashion T Shirt</h4>
        <h2>$139.00</h2>
        <select>
            <option>Select Size</option>
            <option>XL</option>
            <option>XXL</option>
            <option>Small</option>
            <option>Large</option>
        </select>
        <input type="number" value="1">
        <button class="normal">Add to Cart</button>
        <h4>Product Details</h4>
        <span>The Gildan Ultra Cotton T-shirt is made from a substantial 6.0 oz. per sq. yd. fabric
            constructed from 100% cotton, this classic fit preshrunk jersey knit provides unmatched comfort
            with each wear. Featuring a taped neck and shoulder, and a seamless double-needle collar, and available in a range
            of colors, it offers it all in the ultimate head-turning package.
        </span>
    </div>
</section>

<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
        <div class="pro">
            <img src="images/products/n1.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n2.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n3.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
        <div class="pro">
            <img src="images/products/n4.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
        </div>
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