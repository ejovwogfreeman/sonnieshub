<?php

include('admincheck.php');
include('./config/db.php');
include('./partials/header.php');
include('./utils/random_id.php');

if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['user_id'];
    $user = $_SESSION['user'];
    $username = $user['username'];

    // Fetch all orders of the user from the database
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $counter = 1;
}
?>



<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <h2 class="h2">All Products</h2>
    </div>

    <?php if (!empty($products)) : ?>
        <?php
        // Group orders by month
        $groupedOrders = [];
        foreach ($products as $product) {
            $month = date('F Y', strtotime($product['created_at']));
            $groupedOrders[$month][] = $product;
        }
        ?>

        <?php foreach ($groupedOrders as $month => $monthOrders) : ?>
            <h4 class="h4"><?php echo $month; ?></h4>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">PRODUCT NAME</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">DATE CREATED</th>
                            <th scope="col">PRODUCT DETAILS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        ?>
                        <?php foreach ($monthOrders as $product) : ?>
                            <tr>
                                <td scope="row" style="font-weight: bold;"><?php echo $counter++ ?></td>
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo $product['product_category']; ?></td>
                                <td>£ <?php echo number_format($product['product_price']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                                <td>
                                    <small class="bg-primary text-light p-1 rounded">
                                        <a href=<?php echo "/sonnieshub/product/{$product['product_id']}" ?> class="text-decoration-none text-light">View Product</a>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>


    <?php else : ?>
        <p class="mt-3">No orders found in Order history.</p>
    <?php endif; ?>

</div>

<?php include('./partials/footer.php'); ?>

<style>
    .h2 {
        font-size: 30px;
        margin-bottom: 10px;
        margin-left: 20px;
    }

    .h4 {
        margin-bottom: 20px;
    }

    .dashboard-container {
        padding: 20px 100px;
    }

    .dashboard-container .menu-btn {
        font-size: 30px;
    }

    .dashboard-container .content {
        display: flex;
        align-items: start;
        width: 100%;
        margin-top: 20px;
    }

    .dashboard-container .content .welcome {
        padding: 10px 30px;
    }

    .table {
        overflow-x: scroll;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 3px;
    }

    .table table {
        width: 100%;
    }

    .table table a {
        text-decoration: none;
        color: white;
    }

    .table table th {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .table table th,
    td {
        padding: 15px;
        text-align: center;
    }

    .bg-warning {
        background-color: #f0ad4e;
        padding: 5px;
        border-radius: 3px;
        color: #fff;
    }

    .bg-success {
        background-color: #5cb85c;
        padding: 5px;
        border-radius: 3px;
        color: #fff;
    }

    .bg-info {
        background-color: #5bc0de;
        padding: 5px;
        border-radius: 3px;
        color: #fff;
    }

    .bg-danger {
        background-color: #ff5252;
        padding: 5px;
        border-radius: 3px;
        color: #fff;
    }

    .bg-primary {
        background-color: #0275d8;
        padding: 5px;
        border-radius: 3px;
        color: #fff;
    }

    @media screen and (max-width: 1200px) {
        .table table {
            width: 1000px;
        }
    }

    @media screen and (max-width: 799px) {
        .dashboard-container {
            padding: 20px;
        }

    }
</style>