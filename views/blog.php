<?php

include('./partials/header.php');
require_once('./config/db.php');

if (isset($blogId)) {
    // Fetch order details
    $sqlBlog = "SELECT * FROM blogs WHERE blog_id = '$blogId'";
    $resultBlog = mysqli_query($conn, $sqlBlog);
    $blog = mysqli_fetch_assoc($resultBlog);
}

?>

<section id="blogdetails" class="section-p1">
    <div class="single-pro-image">
        <!-- Make sure to use the correct column name for the image path -->
        <?php
        $imageData = $blog['blog_image'];
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
    <div class="single-pro-details" style="margin-top: 20px">
        <h4 style="margin-top: 20px"> <?php echo $blog['blog_title'] ?></h4>
        <h4 style="margin-top: 20px; margin-bottom: 15px">Blog Details</h4>
        <span><?php echo $blog['blog_content'] ?></span>
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