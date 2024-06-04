<?php
include('./config/session.php');
include('./config/db.php');
include('./partials/header.php');


if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

$orderId = isset($orderId) ? $orderId : null;

if ($orderId) {

    // Fetch order details
    $sqlOrder = "SELECT * FROM orders WHERE order_id = '$orderId'";
    $resultOrder = mysqli_query($conn, $sqlOrder);
    $order = mysqli_fetch_assoc($resultOrder);

    // Fetch order items
    $sqlOrderItems = "SELECT * FROM order_items WHERE order_id = '$orderId'";
    $resultOrderItems = mysqli_query($conn, $sqlOrderItems);
    $orderItems = mysqli_fetch_all($resultOrderItems, MYSQLI_ASSOC);

    $counter = 1;
}

$buttonColor = '';
$buttonText = '';

switch ($order['status']) {
    case 'pending':
        $buttonColor = '#2196F3';
        $buttonText = 'Process Order';
        break;
    case 'processing':
        $buttonColor = '#4CAF50';
        $buttonText = 'Confirm Order';
        break;
    case 'ponfirmed':
        $buttonColor = '#4CAF50';
        $buttonText = 'Confirmed';
        break;
    case 'pancelled':
        $buttonColor = '#4CAF50';
        $buttonText = 'Confirm Order';
        break;
}

$cancelButtonText = 'Cancel Order';
$cancelButtonColor = '#FF5252';

// Check the order status and update button text accordingly
switch ($order['status']) {
    case 'processing':
    case 'pending':
    case 'confirmed':
        $cancelButtonText = 'Cancel Order';
        $cancelButtonColor = '#FF5252';
        break;
    case 'cancelled':
        $cancelButtonText = 'cancelled';
        $cancelButtonColor = '#FF5252';
        break;
}

// Check if the order is Confirmed or Cancelled
$isConfirmed = $order['status'] === 'confirmed';
$isCancelled = $order['status'] === 'cancelled';
?>

<style>
    strong {
        width: 150px;
    }

    .disabled-link {
        cursor: not-allowed;
    }
</style>

<div class="order-details" style="margin-top: 100px;">
    <div class="profile">
        <div class="top-status">
            <a href="cart" style="font-size: 30px; color:#088178;"><i class="fa fa-arrow-circle-left"></i></a>
            <div>
                <?php if ($user['is_admin'] === 'true') : ?>
                    <a href=<?php echo "/a2z_food/admin/change_order_status.php?id={$order['order_id']}" ?> style="text-decoration: none; color: white; padding: 5px; border-radius: 3px;  background-color: <?php echo $buttonColor; ?> <?php echo $isConfirmed ? 'disabled-link' : ''; ?>"><?php echo $buttonText; ?></a>
                <?php endif ?>
                <a href=<?php echo "/a2z_food/cancel_order.php?id={$order['order_id']}" ?> style="text-decoration: none; color: white; padding: 5px; border-radius: 3px; background-color: <?php echo $cancelButtonColor; ?> <?php echo $isCancelled ? 'disabled-link' : ''; ?>"><?php echo $cancelButtonText; ?></a>
            </div>
        </div>

        <div class="border rounded p-3 pt-5">
            <h3>Order Details</h3>
            <div class="mt-3">
                <p class="d-flex"><strong>Phone Number: </strong> <span><?php echo $order['phone_number']; ?></span></p>
                <p class="d-flex"><strong>Shipping Address:</strong> <span><?php echo $order['shipping_address']; ?></span></p>
                <p class="d-flex"><strong>Total Price:</strong>NGN&nbsp;<span><?php echo number_format($order['total_price']); ?></span></p>
                <p class="d-flex"><strong>Date Ordered:</strong> <span>
                        <td><?php echo date('M d, Y', strtotime($order['date_ordered'])); ?></td>
                    </span></p>
                <p class="d-flex"><strong>Status:</strong>
                    <small style="color: white; padding: 3px; border-radius: 3px; background-color: <?php
                                                                                                    echo $order['status'] === 'pending' ? '#FFC107' : ($order['status'] === 'processing' ? '#2196F3' : ($order['status'] === 'confirmed' ? '#4CAF50' : ($order['status'] === 'cancelled' ? '#FF5252' : '')));
                                                                                                    ?>">
                        <?php echo ($order['status']); ?>
                    </small>
                </p>
            </div>
        </div>

        <?php if (!empty($orderItems)) : ?>
            <div class="table-responsive">
                <table width="100%">
                    <thead style="border: 1px solid rgba(0,0,0,0.1)">
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price Paid (NGN)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item) : ?>
                            <tr>
                                <td scope="row"><?php echo $counter++ ?></td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price_paid']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('./partials/footer.php'); ?>

<script>
    // Disable links on page load if order is Confirmed or Cancelled
    window.onload = function() {
        <?php if ($isConfirmed || $isCancelled) : ?>
            disableLinks();
        <?php endif; ?>
    };

    function disableLinks() {
        var confirmLink = document.querySelector('.btn-success');
        var cancelLink = document.querySelector('.btn-danger');

        if (confirmLink) {
            confirmLink.classList.add('disabled-link');
            confirmLink.onclick = function() {
                return false;
            };
        }

        if (cancelLink) {
            cancelLink.classList.add('disabled-link');
            cancelLink.onclick = function() {
                return false;
            };
        }
    }
</script>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap");

    .order-details {
        margin-bottom: 50px;
    }

    .order-details .profile {
        width: 700px;
        margin: auto;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    thead {
        border: 5px solid red;
    }

    tr,
    td,
    th {
        text-align: center;
        padding: 5px;
    }

    table {
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .top-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    @media screen and (max-width: 799px) {
        .order-details {
            width: 90%;
            margin: auto;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow-x: scroll;
        }

        .order-details .profile {
            width: 1000px;
        }
    }


    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Spartan", sans-serif;
    }

    h1 {
        font-size: 50px;
        line-height: 64px;
        color: #222;
    }

    h2 {
        font-size: 46px;
        line-height: 54px;
        color: #222;
    }

    h4 {
        font-size: 20px;
        color: #222;
    }

    h6 {
        font-weight: 700;
        font-size: 12x;
    }

    p {
        font-size: 16px;
        color: #465b52;
        margin: 15px 0 20px 0;
    }

    .section-p1 {
        padding: 40px 80px;
    }

    .section-m1 {
        margin: 40px 0;
    }

    button.normal {
        font-size: 14px;
        font-weight: 600;
        padding: 15px 30px;
        color: #000;
        background-color: #fff;
        border-radius: 4px;
        cursor: pointer;
        border: none;
        outline: none;
        transition: 0.2s ease;
    }

    button.white {
        font-size: 13px;
        font-weight: 600;
        padding: 11px 18px;
        color: #fff;
        background-color: transparent;
        cursor: pointer;
        border: 1px solid #fff;
        outline: none;
        transition: 0.2s ease;
    }

    body {
        width: 100%;
    }

    /* Header Start */

    #header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 70px;
        background: #e3e6f3;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
        z-index: 999;
        position: sticky;
        top: 0;
    }

    #navbar {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #navbar li {
        list-style: none;
        padding: 0 20px;
        position: relative;
    }

    #navbar li a {
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        transition: 0.3s ease;
    }

    #navbar li a:hover,
    #navbar li a.active {
        color: #088178;
    }

    #navbar li a:hover::after,
    #navbar li a.active::after {
        content: "";
        width: 30%;
        height: 2px;
        background: #088178;
        position: absolute;
        bottom: -4px;
        left: 20px;
    }

    #close {
        display: none;
    }

    #mobile {
        display: none;
        align-items: center;
    }

    /* Home Page */

    #hero {
        background-image: url("../images/hero4.png");
        width: 100%;
        height: 90vh;
        background-size: cover;
        background-position: top 25% right 0;
        padding: 0 80px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
    }

    #hero h4 {
        padding-bottom: 15px;
    }

    #hero h1 {
        color: #088178;
    }

    #hero button {
        background-image: url("../images/button.png");
        background-color: transparent;
        color: #088178;
        border: 0;
        padding: 14px 80px 14px 65px;
        background-repeat: no-repeat;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
    }

    #feature {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    #feature .fe-box {
        width: 180px;
        text-align: center;
        padding: 25px 15px;
        box-shadow: 20px 20px 34px rgba(0, 0, 0, 0.03);
        border: 1px solid #cce7d0;
        border-radius: 4px;
        margin: 15px 0;
    }

    #feature .fe-box:hover {
        box-shadow: 10px 10px 54px rgba(70, 62, 221, 0.1);
    }

    #feature .fe-box img {
        width: 100%;
        margin-bottom: 10px;
    }

    #feature .fe-box h6 {
        display: inline-block;
        padding: 9px 8px 6px 8px;
        line-height: 1;
        border-radius: 4px;
        color: #088178;
        background-color: #fddde4;
    }

    #feature .fe-box:nth-child(2) h6 {
        background-color: #cdebbc;
    }

    #feature .fe-box:nth-child(3) h6 {
        background-color: #d1e8f2;
    }

    #feature .fe-box:nth-child(4) h6 {
        background-color: #cdd4f8;
    }

    #feature .fe-box:nth-child(5) h6 {
        background-color: #f6dbf6;
    }

    #feature .fe-box:nth-child(6) h6 {
        background-color: #fff2e5;
    }

    #product1 {
        text-align: center;
    }

    #product1 .pro-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
    }

    #product1 .pro {
        padding: 10px 12px;
        border: 1px solid #cce7d0;
        border-radius: 25px;
        cursor: pointer;
        box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.02);
        margin: 15px 0;
        transition: 0.2s ease;
        position: relative;
    }

    #product1 .pro:hover {
        box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.06);
    }

    #product1 .pro img {
        width: 100%;
        border-radius: 20px;
    }

    #product1 .pro .des {
        text-align: start;
        padding: 10px 0;
    }

    #product1 .pro .des span {
        color: #606063;
        font-size: 12px;
    }

    #product1 .pro .des h5 {
        padding-top: 7px;
        color: #1a1a1a;
        font-size: 14px;
    }

    #product1 .pro .des i {
        font-size: 12px;
        color: rgb(243, 181, 25);
    }

    #product1 .pro .des h4 {
        padding-top: 7px;
        font-size: 15px;
        font-weight: 700;
        color: #088178;
    }

    #product1 .pro .cart {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50px;
        background-color: #e8f6ea;
        font-weight: 500;
        color: #088178;
        border: 1px solid #cce7d0;
        position: absolute;
        bottom: 20px;
        right: 10px;
    }

    #banner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-image: url("../images/banner/b2.jpg");
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 40vh;
    }

    #banner h4 {
        color: #fff;
        font-size: 16px;
    }

    #banner h2 {
        color: #fff;
        font-size: 30px;
        padding: 10px 0;
    }

    #banner h2 span {
        color: #ef3636;
    }

    #banner button:hover {
        background-color: #088178;
        color: #fff;
    }

    #sm-banner {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    #sm-banner .banner-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        text-align: center;
        background-image: url("../images/banner/b17.jpg");
        background-size: cover;
        background-position: center;
        min-width: 100%;
        height: 50vh;
        padding: 30px;
    }

    #sm-banner h4 {
        color: #fff;
        font-size: 20px;
        font-weight: 300;
    }

    #sm-banner h2 {
        color: #fff;
        font-size: 28px;
        font-weight: 800;
    }

    #sm-banner span {
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        padding-bottom: 15px;
    }

    #sm-banner .banner-box:hover button {
        background-color: #088178;
        border: 1px solid #088178;
    }

    #sm-banner .banner-box:nth-child(2) {
        background-image: url("../images/banner/b10.jpg");
    }

    #banner3 .banner-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        text-align: center;
        background-image: url("../images/banner/b7.jpg");
        background-size: cover;
        background-position: center;
        min-width: 30%;
        height: 30vh;
        padding: 30px;
        margin-bottom: 20px;
    }

    #banner3 .banner-box:nth-child(2) {
        background-image: url("../images/banner/b4.jpg");
    }

    #banner3 .banner-box:nth-child(3) {
        background-image: url("../images/banner/b18.jpg");
    }

    #banner3 {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 0 80px;
    }

    #banner3 h2 {
        color: #fff;
        font-weight: 900;
        font-size: 22px;
    }

    #banner3 h3 {
        color: #ec544e;
        font-weight: 800;
        font-size: 15px;
    }

    #newsletter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        background-image: url("../images/banner/b14.png");
        background-repeat: no-repeat;
        background-position: 20% 30%;
        background-color: #041e42;
    }

    #newsletter h4 {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
    }

    #newsletter p {
        font-size: 14px;
        font-weight: 600;
        color: #818ea0;
    }

    #newsletter p span {
        color: #ffbd27;
    }

    #newsletter .form {
        display: flex;
        width: 40%;
    }

    #newsletter input {
        height: 3.125rem;
        padding: 0 1.25rem;
        font-size: 14px;
        width: 100%;
        border: 1px solid transparent;
        border-radius: 4px;
        outline: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    #newsletter button {
        background-color: #088178;
        color: #fff;
        white-space: nowrap;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    footer .col {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    footer .logo {
        margin-bottom: 30px;
    }

    footer h4 {
        font-size: 14px;
        padding-bottom: 20px;
    }

    footer p {
        font-size: 13px;
        margin: 0 0 8px 0;
    }

    footer a {
        font-size: 13px;
        text-decoration: none;
        color: #222;
        margin: 0 0 10px 0;
    }

    footer .follow {
        margin-top: 20px;
    }

    footer .follow i {
        color: #465b52;
        padding-right: 4px;
        cursor: pointer;
    }

    footer .install .row img {
        border: 1px solid #088178;
        border-radius: 6px;
        margin: 10px 0 15px 0;
    }

    footer .follow i:hover,
    footer a:hover {
        color: #088178;
    }

    footer .copyright {
        width: 100%;
        text-align: center;
    }

    /* Shop Page */

    #page-header {
        background-image: url("../images/banner/b1.jpg");
        width: 100%;
        height: 40vh;
        background-size: cover;
        display: flex;
        justify-content: center;
        text-align: center;
        flex-direction: column;
        padding: 14px;
    }

    #page-header h2,
    #page-header p {
        color: #fff;
    }

    #pagination {
        text-align: center;
    }

    #pagination a {
        text-decoration: none;
        background-color: #088178;
        padding: 15px 20px;
        border-radius: 4px;
        color: #fff;
        font-weight: 600;
    }

    #pagination a i {
        font-size: 16px;
        font-weight: 600;
    }

    /* Single Product Page */

    #productdetails {
        display: flex;
        margin-top: 20px;
    }

    #productdetails .single-pro-image {
        width: 40%;
        margin-right: 50px;
    }

    .small-image-group {
        display: flex;
        justify-content: space-between;
    }

    .small-img-col {
        flex-basis: 24%;
        cursor: pointer;
    }

    #productdetails .single-pro-details {
        width: 50%;
        padding-top: 30px;
    }

    #productdetails .single-pro-details h4 {
        padding: 40px 0 20px 0;
    }

    #productdetails .single-pro-details h2 {
        font-size: 26px;
    }

    #productdetails .single-pro-details select {
        display: block;
        padding: 5px 10px;
        margin-bottom: 10px;
    }

    #productdetails .single-pro-details input {
        width: 50px;
        height: 47px;
        padding-left: 10px;
        font-size: 16px;
        margin-right: 10px;
    }

    #productdetails .single-pro-details button {
        background-color: #088178;
        color: #fff;
    }

    #productdetails .single-pro-details input:focus {
        outline: none;
    }

    #productdetails .single-pro-details span {
        line-height: 25px;
    }

    /* Blog Page */

    #page-header.blog-header {
        background-image: url("../images/banner/b19.jpg");
    }

    #blog {
        padding: 150px 150px 0 150px;
    }

    #blog .blog-box {
        display: flex;
        align-items: center;
        width: 100%;
        position: relative;
        padding-bottom: 90px;
    }

    #blog .blog-img {
        width: 50%;
        margin-right: 40px;
    }

    #blog img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    #blog .blog-details {
        width: 50%;
    }

    #blog .blog-details a {
        text-decoration: none;
        font-size: 11px;
        color: #000;
        font-weight: 700;
        position: relative;
        transition: 0.3s;
    }

    #blog .blog-details a::after {
        content: "";
        width: 50px;
        height: 1px;
        background-color: #000;
        position: absolute;
        top: 4px;
        right: -60px;
    }

    #blog .blog-details a:hover {
        color: #088178;
    }

    #blog .blog-details a:hover::after {
        background-color: #088178;
    }

    #blog .blog-box h1 {
        position: absolute;
        top: -40px;
        left: 0;
        font-size: 70px;
        font-weight: 700;
        color: #c9cbce;
        z-index: -9;
    }

    /* About Page */

    #page-header.about-header {
        background-image: url("../images/about/banner.png");
    }

    #about-head {
        display: flex;
        align-items: center;
    }

    #about-head img {
        width: 50%;
        height: auto;
    }

    #about-head div {
        padding-left: 40px;
    }

    #about-app {
        text-align: center;
    }

    #about-app .video {
        width: 70%;
        height: 100%;
        margin: 30px auto 0 auto;
    }

    #about-app .video video {
        width: 100%;
        height: 100%;
        border-radius: 20px;
    }

    /* Contact Page */

    #contact-details {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #contact-details .details {
        width: 40%;
    }

    #contact-details .details span,
    #form-details form span {
        font-size: 12px;
    }

    #contact-details .details h2,
    #form-details form h2 {
        font-size: 26px;
        line-height: 35px;
        padding: 20px 0;
    }

    #contact-details .details h3 {
        font-size: 16px;
        padding-bottom: 15px;
    }

    #contact-details .details li {
        list-style: none;
        display: flex;
        padding: 10px 0;
        align-items: center;
    }

    #contact-details .details li i {
        font-size: 14px;
        padding-right: 22px;
    }

    #contact-details .details li p {
        margin: 0;
        font-size: 14px;
    }

    #contact-details .map {
        width: 55%;
        height: 400px;
    }

    #contact-details .map iframe {
        width: 100%;
        height: 100%;
    }

    #form-details {
        display: flex;
        justify-content: space-between;
        margin: 30px;
        padding: 80px;
        border: 1px solid #e1e1e1;
    }

    #form-details form {
        width: 65%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #form-details form input,
    #form-details form textarea {
        width: 100%;
        padding: 12px 15px;
        outline: none;
        margin-bottom: 20px;
        border: 1px solid #e1e1e1;
    }

    #form-details form button {
        background-color: #088178;
        color: #fff;
    }

    #form-details .people div {
        padding-bottom: 25px;
        display: flex;
        align-items: flex-start;
    }

    #form-details .people div img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        margin-right: 15px;
    }

    #form-details .people div p {
        margin: 0;
        font-size: 13px;
        line-height: 25px;
    }

    #form-details .people div span {
        display: block;
        color: #000;
        font-size: 16px;
        font-weight: 600;
    }

    /* Cart Page */

    #cart {
        overflow-x: auto;
    }

    #cart table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        white-space: nowrap;
    }

    #cart table img {
        width: 70px;
    }

    #cart table td:nth-child(1) {
        width: 100px;
        text-align: center;
    }

    #cart table td:nth-child(2) {
        width: 150px;
        text-align: center;
    }

    #cart table td:nth-child(3) {
        width: 250px;
        text-align: center;
    }

    #cart table td:nth-child(4),
    #cart table td:nth-child(5),
    #cart table td:nth-child(6) {
        width: 150px;
        text-align: center;
    }

    #cart table td:nth-child(5) input {
        width: 70px;
        padding: 10px 5px 10px 15px;
    }

    #cart table thead {
        border: 1px solid #e2e9e1;
        border-left: none;
        border-right: none;
    }

    #cart table thead td {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        padding: 18px 0;
    }

    #cart table tbody tr td {
        padding-top: 15px;
    }

    #cart table tbody td {
        font-size: 13px;
    }

    #cart-add {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    #cart-add .coupon {
        width: 50%;
        margin-bottom: 30px;
    }

    #cart-add .coupon h3,
    #cart-add .subtotal h3 {
        padding-bottom: 15px;
    }

    #cart-add .coupon input {
        padding: 10px 20px;
        outline: none;
        width: 60%;
        margin-right: 10px;
        border: 1px solid #e2e9e1;
    }

    #cart-add .coupon button,
    #cart-add .subtotal button {
        background-color: #088178;
        color: #fff;
        padding: 12px 20px;
    }

    #cart-add .subtotal {
        width: 50%;
        margin-bottom: 30px;
        border: 1px solid #e2e9e1;
        padding: 30px;
    }

    #cart-add .subtotal table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }

    #cart-add .subtotal table td {
        width: 50%;
        border: 1px solid #e2e9e1;
        padding: 10px;
        font-size: 13px;
    }

    /* Media Query */

    /* @media (max-width: 1030px) {
  #navbar {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    position: fixed;
    top: 0;
    right: -300px;
    height: 100vh;
    width: 300px;
    background-color: #e3e6f3;
    box-shadow: 0 40px 60px rgba(0, 0, 0, 0.1);
    padding: 80px 0 0 10px;
    transition: 0.3s;
  }

  #navbar.active {
    right: 0px;
  }

  #navbar li {
    margin-bottom: 25px;
  }

  #mobile {
    display: flex;
    align-items: center;
  }

  #mobile i {
    color: #1a1a1a;
    font-size: 24px;
    padding-left: 20px;
  }

  #close {
    display: initial;
    position: absolute;
    top: 30px;
    left: 30px;
    color: #222;
    font-size: 24px;
  }
} */

    @media (max-width: 799px) {
        .section-p1 {
            padding: 40px 40px;
        }

        #header {
            padding: 20px;
            padding-left: 5px;
        }

        #navbar {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            position: fixed;
            top: 0;
            right: -300px;
            height: 100vh;
            width: 300px;
            background-color: #e3e6f3;
            box-shadow: 0 40px 60px rgba(0, 0, 0, 0.1);
            padding: 80px 0 0 10px;
            transition: 0.3s;
        }

        #navbar.active {
            right: 0px;
        }

        #navbar li {
            margin-bottom: 25px;
        }

        #mobile {
            display: flex;
            align-items: center;
        }

        #mobile i {
            color: #1a1a1a;
            font-size: 24px;
            padding-left: 20px;
        }

        #close {
            display: initial;
            position: absolute;
            top: 30px;
            left: 30px;
            color: #222;
            font-size: 24px;
        }

        #lg-bag {
            display: none;
        }

        #hero {
            height: 70vh;
            padding: 0 80px;
            background-position: top 30% right 30%;
        }

        #feature {
            justify-content: center;
        }

        #feature .fe-box {
            margin: 15px 15px;
        }

        /* #product1 .pro-container {
    justify-content: center;
  } */

        #product1 .pro-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }

        #banner {
            height: 20vh;
        }

        #sm-banner .banner-box {
            min-height: 100%;
            height: 30vh;
        }

        #banner3 {
            padding: 0 40px;
        }

        #banner3 .banner-box {
            width: 28%;
        }

        #newsletter .form {
            width: 70%;
        }

        /* Contact Page */

        #form-details {
            padding: 40px;
        }

        #form-details form {
            width: 50%;
        }
    }

    @media (max-width: 477px) {
        .section-p1 {
            padding: 20px;
        }

        #header {
            padding: 10px;
        }

        h1 {
            font-size: 38px;
        }

        h2 {
            font-size: 32px;
        }

        #hero {
            padding: 0 20px;
            background-position: 55%;
        }

        /* #feature {
    justify-content: space-between;
  } */

        #product1 .pro-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-gap: 20px;
        }

        #feature .fe-box {
            width: 155px;
            margin: 0 0 15px 0;
        }

        #product .pro {
            width: 100%;
        }

        #banner {
            height: 40vh;
        }

        #sm-banner .banner-box {
            height: 40vh;
            margin-bottom: 20px;
        }

        #banner3 {
            padding: 0 20px;
        }

        #banner3 .banner-box {
            width: 100%;
        }

        #newsletter {
            padding: 40px 20px;
        }

        #newsletter .form {
            width: 100%;
        }

        footer .copyright {
            text-align: start;
        }

        /* Single Product */
        #productdetails {
            display: flex;
            flex-direction: column;
        }

        #productdetails .single-pro-image {
            width: 100%;
            margin-right: 0px;
        }

        #productdetails .single-pro-details {
            width: 100%;
        }

        /* Blog Page */
        #blog {
            padding: 100px 20px 0 20px;
        }

        #blog .blog-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #blog .blog-img {
            width: 100%;
            margin-right: 0px;
            margin-bottom: 30px;
        }

        #blog .blog-details {
            width: 100%;
        }

        /* About Page */

        #about-head {
            flex-direction: column;
        }

        #about-head img {
            width: 100%;
            margin-bottom: 20px;
        }

        #about-head div {
            padding-left: 0px;
        }

        #about-app .video {
            width: 100%;
        }

        /* Contact Page */

        #contact-details {
            flex-direction: column;
        }

        #contact-details .details {
            width: 100%;
            margin-bottom: 30px;
        }

        #contact-details .map {
            width: 100%;
        }

        #form-details {
            margin: 10px;
            padding: 30px 10px;
            flex-wrap: wrap;
        }

        #form-details form {
            width: 100%;
            margin-bottom: 30px;
        }

        /* Cart Page */

        #cart-add {
            flex-direction: column;
        }

        #cart-add .coupon {
            width: 100%;
        }

        #cart-add .subtotal {
            width: 100%;
            padding: 20px;
        }
    }
</style>