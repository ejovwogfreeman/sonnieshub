<?php

// Start session
// Check if a session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('./partials/header.php');
require_once('./config/db.php');

if (isset($_SESSION['user'])) {
    header('Location: dashboard');
}

$firstName = $lastName = $email = $password = $confirmPassword = '';
$errors = [];

include('./utils/random_id.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST["firstName"])) {
        $errors['firstName'] = 'First name is required.';
    } else {
        $firstName = htmlspecialchars($_POST["firstName"]);
    }

    // Validate last name
    if (empty($_POST["lastName"])) {
        $errors['lastName'] = 'Last name is required.';
    } else {
        $lastName = htmlspecialchars($_POST["lastName"]);
    }

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

    // If no errors, proceed to register the user
    if (empty($errors)) {
        // Check if the email already exists
        $emailCheckQuery = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $emailCheckQuery);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = 'User already exists with this email.';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $username = explode('@', $email)[0]; // Extract the part before '@' in the email
            $userId = generateRandomId(); // Assuming you have this function defined somewhere
            $dateJoined = date('Y-m-d H:i:s'); // Get the current date and time

            // Prepare the SQL statement
            $sql = "INSERT INTO users (user_id, username, first_name, last_name, email, password, date_joined) VALUES ('$userId', '$username', '$firstName', '$lastName', '$email', '$hashedPassword', '$dateJoined')";

            $sql_query = mysqli_query($conn, $sql);

            if ($sql_query) {
                $_SESSION['msg'] = "Account Created for $username successfully";
                header('Location: login');
                exit();
            } else {
                $msg = 'Database error: ' . mysqli_error($conn);
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
}

?>

<form id="auth-form" method="POST">
    <div style="text-align: center; margin-bottom: 30px">
        <img src="images/logo.png" alt="" style="width: 150px;">
        <h3 style="color:#088178">REGISTER TO START SHOPPING</h3>
    </div>
    <?php echo isset($err) ? "<div class='error'>" . $err . "</div>" : ""; ?>
    <div class=" input-container">
        <label for="firstName" class="form-label" placeholder="Enter first name">First Name</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" class="<?php echo isset($errors['firstName']) ? 'is-invalid' : ''; ?>">
        <?php echo isset($errors['firstName']) ? "<div class='invalid-feedback'>" . $errors['firstName'] . "</div>" : ""; ?>
    </div>
    <div class="input-container">
        <label for="lastName" class="form-label" placeholder="Enter last name">Last Name</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" class="<?php echo isset($errors['lastName']) ? 'is-invalid' : ''; ?>">
        <?php echo isset($errors['lastName']) ? "<div class='invalid-feedback'>" . $errors['lastName'] . "</div>" : ""; ?>
    </div>
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
    <div class="input-container">
        <label for="confirmPassword" class="form-label" placeholder="Enter password again">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" value="<?php echo $confirmPassword; ?>" class="<?php echo isset($errors['confirmPassword']) ? 'is-invalid' : ''; ?>">
        <?php echo isset($errors['confirmPassword']) ? "<div class='invalid-feedback'>" . $errors['confirmPassword'] . "</div>" : ""; ?>
    </div>
    <div>
        <button class="btn" type="submit">REGISTER</button>
    </div>
    <div class="bottom-box">
        <p>Already have an account? <a href="login" style="color:#088178">LOGIN</a></p>
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
        font-size: 16px;
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