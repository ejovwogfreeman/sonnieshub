<?php
// Start session
include('./partials/header.php');
require_once('./config/db.php');

if (isset($_SESSION['user'])) {
    header('Location: /sonnieshub/dashboard');
}

include('./utils/random_id.php');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
}

// Fetch blogs from the database
$sql = "SELECT * FROM blogs";
$result = mysqli_query($conn, $sql);

$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<section id="page-header" class="blog-header">
    <h2>#readmore</h2>
    <p>Read all case studies about our products!</p>
</section>

<section id="blog">
    <?php foreach ($blogs as $blog) : ?>
        <div class="blog-box">
            <div class="blog-img">
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
                <img src="<?php echo $img_src ?>" alt="">
            </div>
            <div class="blog-details">
                <h4><?php echo $blog['blog_title']; ?></h4>
                <p><?php echo $blog['blog_content']; ?></p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1><?php echo date('d M Y', strtotime($blog['created_at'])); ?></h1>
        </div>
    <?php endforeach; ?>
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

<?php include('./partials/footer.php'); ?>