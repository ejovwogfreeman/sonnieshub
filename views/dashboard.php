<?php

include('./config/session.php');
include('./partials/header.php');

?>


<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <div class="welcome">
            <h2>Your Dashboard</h2>
            <p>Welcome, <?php echo $user['username'] ?> <?php echo $user['is_admin'] == 'true' ? '(admin panel)!' : '' ?></p>
        </div>
    </div>
</div>
<?php include('./partials/footer.php'); ?>

<style>
    .dashboard-container .menu-btn {
        font-size: 30px;
        margin-top: 10px;
    }

    .dashboard-container .content {
        display: flex;
        align-items: start;
        padding: 0 100px;
        width: 100%;
        margin-top: 20px;
    }

    .dashboard-container .content .welcome {
        padding: 10px 30px;
    }
</style>