<?php

session_start();
include('./config/db.php');
include('./partials/header.php');

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id = '$id'";

$sql_query = mysqli_query($conn, $sql);

$product = mysqli_fetch_all($sql_query, MYSQLI_ASSOC)[0];

?>

<style>
    .img-style {
        height: 500px;
        width: 500px;
        object-fit: cover;

        @media (max-width: 991px) {
            width: 100%;
            height: auto
        }
    }
</style>

<div class="container" style="margin-top: 100px;">
    <div class="d-lg-flex align-items-center">
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
        <img class="border rounded img-style" src="<?php echo $img_src ?>" alt="<?php echo $product['product_name'] ?>">
        <div class="ms-lg-3 mt-lg-0 mt-3 d-flex flex-column justify-content-between">
            <h3 class="card-title"><?php echo ucwords($product['product_name']) ?></h3>
            <small class="bg-success text-light rounded p-1 px-2" style="width: fit-content; font-size: 12px"><?php echo $product['product_category'] ?></small>
            <P class="my-5" style="text-align: justify;"><?php echo ucfirst($product['product_description']) ?></P>
            <div class=" d-flex align-items-center justify-content-between">
                <h4 class="card-text me-5">NGN <?php echo number_format($product['product_price']) ?></h4>
                <a href=<?php echo "add_to_cart.php?id={$product['product_id']}" ?> class="btn btn-primary">ADD TO CART</a>
            </div>
            <?php if (isset($_SESSION['user']) && $_SESSION['user'][0]['is_admin'] === 'true') : ?>
                <div class="mt-3">
                    <a href=<?php echo "/a2z_food/admin/update_product.php?id={$product['product_id']}" ?> class="btn btn-outline-primary me-1">UPDATE</a>
                    <a href=<?php echo "/a2z_food/admin/delete_product.php?id={$product['product_id']}" ?> class="btn btn-outline-danger">DELETE</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php include('./partials/footer.php'); ?>