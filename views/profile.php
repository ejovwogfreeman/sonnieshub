<?php

ob_start();
include('./config/session.php');
include('./config/db.php');
include('./partials/header.php');
include('./utils/random_id.php');

if (isset($_SESSION['user'])) {
    // Fetch user details based on the session
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
    $is_admin = $user['is_admin'];

    // Extract user ID from the route
    $userIdFromRoute = $matches[1] ?? null;

    if ($userIdFromRoute) {
        // If the user ID from the route is not null
        $profileUserId = $userIdFromRoute;

        if (!$is_admin && $profileUserId !== $userId) {
            // If the user is not an admin and tries to access another user's profile,
            // redirect them to their own profile
            header('Location: /sonnieshub/profile');
            exit();
        }
        if (!$is_admin && $profileUserId == $userId) {
            // If the user is not an admin and tries to access his profile,
            // redirect them to their own profile
            header('Location: /sonnieshub/profile');
            exit();
        }
    } else {
        // If no ID is provided in the route, use the logged-in user's ID
        $profileUserId = $userId;
    }

    // Fetch user details based on the profile user ID using a prepared statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $profileUserId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        // Check if a user with the specified ID exists
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
        } else {
            $_SESSION['msg'] = "User with this id does not exist";
            header('Location: /sonnieshub/dashboard');
            exit();
        }
    } else {
        $_SESSION['msg'] = "Error fetching user details";
        header('Location: /sonnieshub/dashboard');
        exit();
    }

    // Extract user details
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
    $userName = $user['username'];
    $email = $user['email'];
    $phoneNumber = $user['phone_number'];
    $address = $user['address'];
    $birthday = $user['date_of_birth'];
    $imageData = $user['profile_picture'];

    // Check if the logged-in user is viewing their own profile
    $headerText = ($userId == $profileUserId) ? "Your Profile" : "$userName's Profile";
}

ob_end_flush();
?>



<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <h2 class="h2"><?php echo $headerText; ?></h2>
    </div>

    <div class='profile'>
        <?php

        if (!empty($imageData)) {
            $imageInfo = getimagesizefromstring($imageData);

            if ($imageInfo !== false) {
                $imageFormat = $imageInfo['mime'];
                $img_src = "data:$imageFormat;base64," . base64_encode($imageData);
            } else {
                echo "Unable to determine image type.";
            }
        } else {
            // If no image is available, use the default image
            $img_src = "images/default.jpg";
        }
        ?>
        <img class="profile-image" src="<?php echo $img_src; ?>" alt="<?php echo $user['username']; ?>">
        <div class="mt-3">
            <strong class="d-block mt-2">First Name:</strong>
            <span class="d-block"><?php echo $firstName ?></span>
            <hr>
            <strong class="d-block mt-2">Last Name:</strong>
            <span class="d-block"><?php echo $lastName ?></span>
            <hr>
            <strong class="d-block mt-2">Username:</strong>
            <span class="d-block"><?php echo $userName ?></span>
            <hr>
            <strong class="d-block mt-2">Email:</strong>
            <span class="d-block"><?php echo $email ?></span>
            <hr>
            <strong class="d-block mt-2">Phone Number:</strong>
            <span class="d-block"><?php echo $phoneNumber ?></span>
            <hr>
            <strong class="d-block mt-2">Address:</strong>
            <span class="d-block"><?php echo $address ?></span>
            <hr>
            <strong class="d-block mt-2">Birthday:</strong>
            <span class="d-block"><?php echo $birthday ?></span>
        </div>
    </div>

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

    .profile {
        width: 70%;
        margin: auto;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 30px;
    }

    .profile img {
        width: 100px;
        height: 100px;
        margin: auto;
        display: block;
        border: 3px solid #088178;
        border-radius: 50%;
        margin-bottom: 30px;
    }

    .profile hr {
        margin: 10px 0px 20px 0px;
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

    @media screen and (max-width: 477px) {
        .profile {
            width: 100%;
        }
    }
</style>