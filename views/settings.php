<?php

ob_start();
include('./config/session.php');
include('./config/db.php');
include('./partials/header.php');
include('./utils/random_id.php');

// Fetch user data from the database
$user_id = $_SESSION['user']['user_id']; // Assuming you have user_id stored in session

$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Initialize variables with user data
$email = $user['email'];
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$phone = $user['phone_number'];
$address = $user['address'];
$dob = $user['date_of_birth'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $errors = [];

    // Validate inputs
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($first_name)) {
        $errors['first_name'] = 'First name is required';
    }
    if (empty($last_name)) {
        $errors['last_name'] = 'Last name is required';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    }
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    }
    if (empty($dob)) {
        $errors['dob'] = 'Date of birth is required';
    }

    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    if (in_array($imageFileType, $allowedExtensions)) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($image);
    } else {
        $errors['profileImage'] = 'Product image is required.';
    }

    // Update user data if no errors
    if (empty($errors)) {
        $imageData = mysqli_real_escape_string($conn, $imageData);
        $query = "UPDATE users SET email = '$email', first_name = '$first_name', last_name = '$last_name', phone_number = '$phone', address = '$address', profile_picture = '$imageData', date_of_birth = '$dob' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['msg'] = "Profile updated successfully!";
            header("Location: dashboard");
            exit();
        } else {
            $err = "Failed to update profile. Please try again.";
        }
    }
}

?>

<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <h2 class="h2">Update Profile</h2>
    </div>

    <div class='profile'>
        <?php
        $imageData = $user['profile_picture'];

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
        <form id="auth-form" method="POST" enctype="multipart/form-data">
            <div style="text-align: center; margin-bottom: 30px">
                <h3 style="color:#088178">UPDATE PROFILE</h3>
            </div>
            <?php
            if (isset($_SESSION['msg'])) {
                echo "<div class='success-msg'>" . $_SESSION['msg'] . "</div>";
                unset($_SESSION['msg']); // Clear the message after displaying it
            }
            ?>
            <?php echo isset($err) ? "<div class='error'>" . $err . "</div>" : ""; ?>
            <div class="input-container">
                <label for="email" class="form-label" placeholder="Enter email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="<?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['email']) ? "<div class='invalid-feedback'>" . $errors['email'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="first_name" class="form-label" placeholder="Enter first name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" class="<?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['first_name']) ? "<div class='invalid-feedback'>" . $errors['first_name'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="last_name" class="form-label" placeholder="Enter last name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" class="<?php echo isset($errors['last_name']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['last_name']) ? "<div class='invalid-feedback'>" . $errors['last_name'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="phone" class="form-label" placeholder="Enter phone number">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="<?php echo isset($errors['phone']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['phone']) ? "<div class='invalid-feedback'>" . $errors['phone'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="address" class="form-label" placeholder="Enter address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" class="<?php echo isset($errors['address']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['address']) ? "<div class='invalid-feedback'>" . $errors['address'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="dob" class="form-label" placeholder="Enter date of birth">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" class="<?php echo isset($errors['dob']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['dob']) ? "<div class='invalid-feedback'>" . $errors['dob'] . "</div>" : ""; ?>
            </div>
            <div class="input-container">
                <label for="image" class="form-label" placeholder="Upload product image">Profile Picture</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp" class="<?php echo isset($errors['profileImage']) ? 'is-invalid' : ''; ?>">
                <?php echo isset($errors['profileImage']) ? "<div class='invalid-feedback'>" . $errors['profileImage'] . "</div>" : ""; ?>
            </div>
            <div>
                <button class="btn" type="submit">UPDATE PROFILE</button>
            </div>
        </form>

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

        #auth-form {
            width: 500px;
            margin: auto;
            margin-top: 50px;
            margin-bottom: 100px;
            padding: 50px 30px 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Light grey box shadow */
            border-radius: 8px;
            background-color: #fff;
        }

        .input-container {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 18px;
            color: #088178;
            display: block;
            margin-bottom: 10px;
        }

        select,
        textarea,
        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="email"],
        input[type="password"] {
            color: #088178;
            font-size: 18px;
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        textarea,
        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #088178;
            box-shadow: 0px 0px 5px rgba(8, 129, 120, 0.5);
            /* Light green box shadow on focus */
            outline: none;
        }

        textarea.is-invalid,
        input[type="text"].is-invalid,
        input[type="date"].is-invalid,
        input[type="file"].is-invalid,
        input[type="email"].is-invalid,
        input[type="password"].is-invalid {
            margin-top: 10px;
            border-color: red;
            box-shadow: 0px 0px 5px rgba(255, 0, 0, 0.5);
            /* Light red box shadow on error */
        }

        .invalid-feedback {
            margin-top: 10px;
            color: red;
            font-size: 14px;
        }

        .success-msg {
            padding: 15px;
            margin-bottom: 20px;
            color: #0f5132;
            background-color: #d1e7dd;
            border: 1px solid #badbcc;
            border-radius: 3px;
        }

        .success-message {
            color: #088178;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            margin-top: 20px;
        }

        .btn {
            background-color: #088178;
            border: 1px solid #088178;
            color: #fff;
            padding: 10px;
            width: 100%;
            font-size: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #06695a;
            border-color: #06695a;
        }

        .bottom-box {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .bottom-box p,
        .bottom-box a {
            font-size: 14px;
        }

        @media (max-width: 799px) {
            #auth-form {
                margin-top: 30px;
                margin-bottom: 50px;
                padding: 50px 30px 50px;
                width: 90%;
            }
        }

        @media (max-width: 477px) {
            .bottom-box {
                margin-top: 30px;
                display: block;
                align-items: center;
                justify-content: space-between;
                font-size: 16px;
            }

            #auth-form {
                padding: 50px 20px 50px;
            }
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