<?php

// Start session
session_start();

include('./partials/header.php');
include('./config/db.php');

$email = $password = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $errors['password'] = 'Password is required.';
    } else {
        $password = $_POST["password"];
    }

    // If no errors, proceed to login the user
    if (empty($errors)) {
        // Check if the email exists
        $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $emailCheckQuery);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            var_dump($user);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['msg'] = 'Login Successful';
                $_SESSION['user'] = $user;
                // header('Location: dashboard');
                exit();
            } else {
                $errors['password'] = 'Invalid password.';
            }
        } else {
            $errors['email'] = 'No user found with this email.';
        }
    }

    // Close the database connection
    mysqli_close($conn);
}

?>

<form id="auth-form" method="POST">
    <div style="text-align: center; margin-bottom: 30px">
        <img src="images/logo.png" alt="" style="width: 150px;">
        <h3 style="color:#088178">LOGIN TO CONTINUE SHOPPING</h3>
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
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="<?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>">
        <?php echo isset($errors['email']) ? "<div class='invalid-feedback'>" . $errors['email'] . "</div>" : ""; ?>
    </div>
    <div class="input-container">
        <label for="password" class="form-label" placeholder="Enter password">Password</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" class="<?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>">
        <?php echo isset($errors['password']) ? "<div class='invalid-feedback'>" . $errors['password'] . "</div>" : ""; ?>
    </div>
    <div>
        <button class="btn" type="submit">LOGIN</button>
    </div>
    <div class="bottom-box">
        <p>New Here? <a href="register" style="color:#088178">REGISTER</a></p>
        <a href="forgot_password" style="color:#088178">FORGOT PASSWORD?</a>
    </div>
</form>

<?php

include('./partials/footer.php');

?>

<style>
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

    input[type="text"],
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

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #088178;
        box-shadow: 0px 0px 5px rgba(8, 129, 120, 0.5);
        /* Light green box shadow on focus */
        outline: none;
    }

    input[type="text"].is-invalid,
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
            margin-top: 50px;
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
</style>