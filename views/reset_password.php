<?php

// Start output buffering
ob_start();

// Include required files
session_start();
include('./config/db.php');
include('./utils/random_id.php');

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string from the URI
$requestUri = strtok($requestUri, '?');

// Define the base path
$basePath = '/sonnieshub';

// Remove the base path from the request URI
$requestUri = str_replace($basePath, '', $requestUri);

// Ensure the requestUri starts with a slash
if ($requestUri === '') {
    $requestUri = '/';
}

// Handle dynamic routes
if (preg_match('#^/reset_password/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$#', $requestUri, $matches)) {
    $email = $matches[1];

    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $user_id = $user['user_id'];
        $errors = [];
        $password = '';
        $confirmPassword = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            if (empty($_POST["password"])) {
                $errors['password'] = 'Password is required.';
            } elseif (strlen($_POST["password"]) < 8) {
                $errors['password'] = 'Password must be at least 8 characters.';
            } else {
                $password = $_POST["password"];
            }

            // Validate confirm password
            if (empty($_POST["confirmPassword"])) {
                $errors['confirmPassword'] = 'Confirm password is required.';
            } elseif ($_POST["confirmPassword"] !== $_POST["password"]) {
                $errors['confirmPassword'] = 'Passwords do not match.';
            } else {
                $confirmPassword = $_POST["confirmPassword"];
            }

            // Update user password if no errors
            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $query = "UPDATE users SET password = '$hashedPassword' WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $_SESSION['msg'] = "Password reset successfully!";
                    header("Location: /sonnieshub/login");
                    exit();
                } else {
                    $err = "Failed to reset password. Please try again.";
                }
            }
        }

        // Display the reset password form
?>
        <div class="dashboard-container">
            <div class='profile'>
                <form id="auth-form" method="POST" enctype="multipart/form-data">
                    <div style="text-align: center; margin-bottom: 30px">
                        <h3 style="color:#088178">RESET PASSWORD</h3>
                    </div>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo "<div class='success-msg'>" . $_SESSION['msg'] . "</div>";
                        unset($_SESSION['msg']); // Clear the message after displaying it
                    }
                    ?>
                    <?php echo isset($err) ? "<div class='error'>" . $err . "</div>" : ""; ?>
                    <div class="input-container">
                        <label for="password" class="form-label" placeholder="Enter password">Password</label>
                        <input type="password" id="password" name="password" value="<?php echo $password; ?>" class="<?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>">
                        <?php echo isset($errors['password']) ? "<div class='invalid-feedback'>" . $errors['password'] . "</div>" : ""; ?>
                    </div>
                    <div class="input-container">
                        <label for="confirmPassword" class="form-label" placeholder="Enter password again">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="<?php echo $confirmPassword; ?>" class="<?php echo isset($errors['confirmPassword']) ? 'is-invalid' : ''; ?>">
                        <?php echo isset($errors['confirmPassword']) ? "<div class='invalid-feedback'>" . $errors['confirmPassword'] . "</div>" : ""; ?>
                    </div>
                    <div>
                        <button class="btn" type="submit">RESET PASSWORD</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    } else {
        // User not found, display 404
        require 'views/404.php';
    }
} else {
    // No route matched, display 404
    require 'views/404.php';
}

// End output buffering and flush output
ob_end_flush();
?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Spartan", sans-serif;
    }

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
        margin-top: 100px;
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