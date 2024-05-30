<?php

include('./config/session.php');
include('./partials/header.php');

function showFlyingAlert($message, $className)
{
    echo <<<EOT
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var alertDiv = document.createElement("div");
            alertDiv.className = "{$className}";
            alertDiv.innerHTML = "{$message}";
            document.body.appendChild(alertDiv);

            // Triggering reflow to enable animation
            alertDiv.offsetWidth;

            // Add a class to trigger the fly-in animation
            alertDiv.style.left = "10px";

            // Remove the fly-in style after 3 seconds
            setTimeout(function() {
                alertDiv.style.left = "10px";
            }, 2000);

            // Add a class to trigger the fly-out animation after 3 seconds
            setTimeout(function() {
                alertDiv.style.left = "-300px";
            }, 4000);

            // Remove the element after the total duration of the animation (9 seconds)
            setTimeout(function() {
                alertDiv.remove();
            }, 6000);
        });
    </script>
EOT;
}

if (isset($_SESSION['msg'])) {
    $message = $_SESSION['msg'];
    if (stristr($message, "successfully") || stristr($message, "Successfully") || stristr($message, "SUCCESSFUL")) {
        showFlyingAlert($message, "flying-success-alert");
        unset($_SESSION['msg']);
    } else {
        showFlyingAlert($message, "flying-danger-alert");
        unset($_SESSION['msg']);
    }
}

?>

<style>
    .flying-success-alert {
        position: fixed;
        z-index: 11111111111111;
        top: 15px;
        left: -300px;
        background-color: #088178;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        transition: left 1.5s ease-in-out;
    }

    .flying-danger-alert {
        position: fixed;
        z-index: 11111111111111;
        top: 15px;
        left: -300px;
        background-color: #FF5252;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        transition: left 1.5s ease-in-out;
    }
</style>

<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <div class="welcome">
            <h2>Your Dashboard</h2>
            <p>Welcome, <?php echo $user['username'] ?> <?php echo $user['is_admin'] == 'true' ? '(admin panel)!' : '' ?></p>
        </div>
    </div>

    <div class="info-boxes">
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(2889) ?></h3>
            <hr>
            <div class="text">
                <h3>All Users</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm-8 0c-.29 0-.62.02-.97.05C7.63 13.86 9 15.03 9 16.5V19H2v-2.5c0-1.47 1.37-2.64 3.97-3.45c-.35-.03-.68-.05-.97-.05z" />
                </svg>
            </div>
        </a>
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(1709) ?></h3>
            <hr>
            <div class="text">
                <h3>All Orders</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9 20c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2m8-2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2m-9.8-3.2v-.1l.9-1.7h7.4c.7 0 1.4-.4 1.7-1l3.9-7l-1.7-1l-3.9 7h-7L4.3 2H1v2h2l3.6 7.6L5.2 14c-.1.3-.2.6-.2 1c0 1.1.9 2 2 2h12v-2H7.4c-.1 0-.2-.1-.2-.2M12 9.3l-.6-.5C9.4 6.9 8 5.7 8 4.2C8 3 9 2 10.2 2c.7 0 1.4.3 1.8.8c.4-.5 1.1-.8 1.8-.8C15 2 16 2.9 16 4.2c0 1.5-1.4 2.7-3.4 4.6z" />
                </svg>
            </div>
        </a>
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(7007) ?></h3>
            <hr>
            <div class="text">
                <h3>All Products</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                    <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                        <path d="M44 14L24 4L4 14v20l20 10l20-10z" />
                        <path stroke-linecap="round" d="m4 14l20 10m0 20V24m20-10L24 24M34 9L14 19" />
                    </g>
                </svg>
            </div>
        </a>
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(2731) ?></h3>
            <hr>
            <div class="text">
                <h3>All Blogs</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                    <path fill="currentColor" d="M14.25 4A6.25 6.25 0 0 0 8 10.25v27.5A6.25 6.25 0 0 0 14.25 44h24.5a1.25 1.25 0 1 0 0-2.5h-24.5a3.75 3.75 0 0 1-3.675-3H37.75A2.25 2.25 0 0 0 40 36.25v-26A6.25 6.25 0 0 0 33.75 4zM37.5 36h-27V10.25a3.75 3.75 0 0 1 3.75-3.75h19.5a3.75 3.75 0 0 1 3.75 3.75zM16.25 10A2.25 2.25 0 0 0 14 12.25v4.5A2.25 2.25 0 0 0 16.25 19h15.5A2.25 2.25 0 0 0 34 16.75v-4.5A2.25 2.25 0 0 0 31.75 10zm.25 6.5v-4h15v4z" />
                </svg>
            </div>
        </a>
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(1390) ?></h3>
            <hr>
            <div class="text">
                <h3>Your Orders</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9 20c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2m8-2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2m-9.8-3.2v-.1l.9-1.7h7.4c.7 0 1.4-.4 1.7-1l3.9-7l-1.7-1l-3.9 7h-7L4.3 2H1v2h2l3.6 7.6L5.2 14c-.1.3-.2.6-.2 1c0 1.1.9 2 2 2h12v-2H7.4c-.1 0-.2-.1-.2-.2M12 9.3l-.6-.5C9.4 6.9 8 5.7 8 4.2C8 3 9 2 10.2 2c.7 0 1.4.3 1.8.8c.4-.5 1.1-.8 1.8-.8C15 2 16 2.9 16 4.2c0 1.5-1.4 2.7-3.4 4.6z" />
                </svg>
            </div>
        </a>
        <a href='' class="item">
            <h3 class="fig"><?php echo number_format(2840) ?></h3>
            <hr>
            <div class="text">
                <h3>Completed Orders</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9 20c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2m8-2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2m-9.8-3.2v-.1l.9-1.7h7.4c.7 0 1.4-.4 1.7-1l3.9-7l-1.7-1l-3.9 7h-7L4.3 2H1v2h2l3.6 7.6L5.2 14c-.1.3-.2.6-.2 1c0 1.1.9 2 2 2h12v-2H7.4c-.1 0-.2-.1-.2-.2M18 2.8l-1.4-1.4l-4.8 4.8l-2.6-2.6L7.8 5l4 4z" />
                </svg>
            </div>
        </a>
    </div>
</div>

<?php include('./partials/footer.php'); ?>

<style>
    h2 {
        font-size: 30px;
    }

    .dashboard-container {
        padding: 0 100px;
    }

    .dashboard-container .menu-btn {
        font-size: 30px;
        margin-top: 10px;
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

    .info-boxes {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 20px;
        margin-bottom: 50px;
    }

    .item {
        background-color: #088178;
        color: #fff;
        padding: 20px;
        font-size: 18px;
        border-radius: 4px;
        text-decoration: none;
        height: 160px;
    }

    .item .fig {
        font-size: 35px;
        margin-bottom: 30px
    }

    .item hr {
        margin-bottom: 10px;
    }

    .item .text {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .item .text svg {
        font-size: 30px;
    }

    @media screen and (max-width: 1200px) {
        .info-boxes {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media screen and (max-width: 799px) {

        h2 {
            font-size: 20px;
        }

        .dashboard-container {
            padding: 0 20px;
        }

        .info-boxes {
            grid-template-columns: repeat(1, 1fr);
        }

        .info-boxes .top {
            display: flex;
        }

    }
</style>