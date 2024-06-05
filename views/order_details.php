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
            <a href="/sonnieshub/dashboard" style="font-size: 30px; color:#088178;"><i class="fa fa-arrow-circle-left"></i></a>
            <div>
                <?php if ($user['is_admin'] === 'true') : ?>
                    <a href=<?php echo "/sonnieshub/admin/change_order_status/{$order['order_id']}" ?> style="text-decoration: none; color: white; padding: 5px; border-radius: 3px;  background-color: <?php echo $buttonColor; ?> <?php echo $isConfirmed ? 'disabled-link' : ''; ?>"><?php echo $buttonText; ?></a>
                <?php endif ?>
                <a href=<?php echo "/sonnieshub/cancel_order/{$order['order_id']}" ?> style="text-decoration: none; color: white; padding: 5px; border-radius: 3px; background-color: <?php echo $cancelButtonColor; ?> <?php echo $isCancelled ? 'disabled-link' : ''; ?>"><?php echo $cancelButtonText; ?></a>
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
                            <th scope="col">Price Paid (£)</th>
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
            margin-bottom: 50px;
        }

        .order-details .profile {
            width: 1000px;
        }
    }
</style>

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