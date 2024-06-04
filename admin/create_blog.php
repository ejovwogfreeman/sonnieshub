<?php
// Include necessary files and initialize session
include('admincheck.php');
include('./config/db.php');
include('./partials/header.php');
include('./utils/random_id.php');

// Initialize variables and errors array
$blogTitle = $blogContent = '';
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate blog title
    if (empty($_POST["blogTitle"])) {
        $errors['blogTitle'] = 'Blog title is required.';
    } else {
        $blogTitle = htmlspecialchars($_POST["blogTitle"]);
    }

    // Validate blog content
    if (empty($_POST["blogContent"])) {
        $errors['blogContent'] = 'Blog content is required.';
    } else {
        $blogContent = htmlspecialchars($_POST["blogContent"]);
    }

    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    if (in_array($imageFileType, $allowedExtensions)) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($image);
    } else {
        $errors['blogImage'] = 'Blog image is required.';
    }

    // If no errors, proceed to insert blog into the database
    if (empty($errors)) {
        // Use mysqli real escape string to prevent SQL injection
        $blogTitle = mysqli_real_escape_string($conn, $blogTitle);
        $blogContent = mysqli_real_escape_string($conn, $blogContent);
        $imageData = mysqli_real_escape_string($conn, $imageData);

        $blogId = generateRandomId();
        $dateUploaded = date('Y-m-d H:i:s');

        $sql = "INSERT INTO blogs (blog_id, blog_title, blog_content, blog_image, created_at) VALUES ('$blogId', '$blogTitle', '$blogContent', '$imageData', '$dateUploaded')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg'] = 'Blog uploaded successfully.';
            header('Location: /sonnieshub/dashboard');
            exit();
        } else {
            $errors['db'] = 'There was an error uploading the blog. Please try again.';
        }

        // Close the database connection
        mysqli_close($conn);
    }
}
?>

<div class="dashboard-container">

    <?php include('./partials/sidebar.php'); ?>

    <div class="content">
        <button id="menuBtn" class="menu-btn">&#9776;</button>
        <h2 class="h2"></h2>
    </div>

    <form id="auth-form" method="POST" enctype="multipart/form-data">
        <div style="text-align: center; margin-bottom: 30px">
            <img src="images/logo.png" alt="" style="width: 150px;">
            <h3 style="color:#088178">CREATE BLOG</h3>
        </div>
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='success-msg'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']); // Clear the message after displaying it
        }
        ?>
        <?php echo isset($errors['db']) ? "<div class='error'>" . $errors['db'] . "</div>" : ""; ?>
        <div class="input-container">
            <label for="blogTitle" class="form-label" placeholder="Enter blog title">Blog Title</label>
            <input type="text" id="blogTitle" name="blogTitle" value="<?php echo htmlspecialchars($blogTitle, ENT_QUOTES); ?>" class="<?php echo isset($errors['blogTitle']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['blogTitle']) ? "<div class='invalid-feedback'>" . $errors['blogTitle'] . "</div>" : ""; ?>
        </div>
        <div class="input-container">
            <label for="blogContent" class="form-label" placeholder="Enter blog content">Blog Content</label>
            <textarea id="blogContent" name="blogContent" class="<?php echo isset($errors['blogContent']) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($blogContent, ENT_QUOTES); ?></textarea>
            <?php echo isset($errors['blogContent']) ? "<div class='invalid-feedback'>" . $errors['blogContent'] . "</div>" : ""; ?>
        </div>
        <div class="input-container">
            <label for="image" class="form-label" placeholder="Upload blog image">Blog Image</label>
            <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp" class="<?php echo isset($errors['blogImage']) ? 'is-invalid' : ''; ?>">
            <?php echo isset($errors['blogImage']) ? "<div class='invalid-feedback'>" . $errors['blogImage'] . "</div>" : ""; ?>
        </div>
        <div>
            <button class="btn" type="submit">UPLOAD BLOG</button>
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