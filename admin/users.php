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
    $sql = "SELECT * FROM users ORDER BY date_joined DESC";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $counter = 1;
}
?>



<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <h2 class="h2">All Users</h2>
    </div>

    <?php if (!empty($users)) : ?>
        <?php
        // Group orders by month
        $groupedUsers = [];
        foreach ($users as $user) {
            $month = date('F Y', strtotime($user['date_joined']));
            $groupedUsers[$month][] = $user;
        }
        ?>

        <?php foreach ($groupedUsers as $month => $monthOrders) : ?>
            <h4 class="h4"><?php echo $month; ?></h4>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">USERNAME</th>
                            <th scope="col">FIRST NAME</th>
                            <th scope="col">LAST NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">DATE JOINED</th>
                            <th scope="col">USER DETAILS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        ?>
                        <?php foreach ($monthOrders as $user) : ?>
                            <tr>
                                <td scope="row" style="font-weight: bold;"><?php echo $counter++ ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['first_name']; ?></td>
                                <td><?php echo $user['last_name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($user['date_joined'])); ?></td>
                                <td>
                                    <small class="bg-primary text-light p-1 rounded">
                                        <a href=<?php echo "/sonnieshub/user_profile/{$user['user_id']}" ?> class="text-decoration-none text-light">View Profile</a>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>


    <?php else : ?>
        <p class="mt-3">No users found in Order history.</p>
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