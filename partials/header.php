<?php

// // include('./views/get_cart_items.php');
// include('./partials/header.php');

// if (isset($_SESSION['user'])) {
//     $user = $_SESSION['user'];
//     $userId = $user['user_id'];
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerce website</title>

    <!-- font-awesome cdn link -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <section id="header">
        <a href="/sonnieshub"><img src="images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="/sonnieshub">Home</a></li>
                <li><a href="shop">Shop</a></li>
                <li><a href="blog">Blog</a></li>
                <li><a href="about">About</a></li>
                <li><a href="contact">Contact</a></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li><a href="register">Register</a></li>
                    <li><a href="login">Login</a></li>
                <?php else : ?>
                    <li><a href="dashboard">Dashboard</a></li>
                    <li><a href="logout">Logout</a></li>
                    <li id="lg-bag"><a href="cart"><i class="far fa-shopping-bag"></i></a></li>
                <?php endif ?>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>