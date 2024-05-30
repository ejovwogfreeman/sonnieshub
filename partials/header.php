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
    <?php
    // Get the current URL
    $url = $_SERVER['REQUEST_URI'];

    // // Check if 'admin' is in the URL
    // if (strpos($url, 'admin') !== false) {
    //     echo '<link rel="stylesheet" href="../css/style.css">';
    // } else {
    //     echo '<link rel="stylesheet" href="../css/style.css">';
    // }

    $pattern = '/\/profile\/[0-9a-zA-Z]+$/';

    if (strpos($url, 'admin') !== false) {
        echo '<link rel="stylesheet" href="../css/style.css">';
    } else {
        // Define the pattern to match '/profile/' followed by an ID

        if (preg_match($pattern, $url)) {
            echo '<link rel="stylesheet" href="../css/style.css">';
        } else {
            echo '<link rel="stylesheet" href="css/style.css">';
        }
    }

    ?>


</head>

<body>

    <section id="header">
        <?php
        // Get the current URL
        $url = $_SERVER['REQUEST_URI'];

        if (strpos($url, 'admin') !== false) {
            echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
        } else {
            if (preg_match($pattern, $url)) {
                echo '<a href="/sonnieshub"><img src="../images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            } else {
                echo '<a href="/sonnieshub"><img src="images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
            }
        }

        ?>
        <div>
            <ul id="navbar">
                <li><a class="active" href="/sonnieshub/">Home</a></li>
                <li><a href="/sonnieshub/shop">Shop</a></li>
                <li><a href="/sonnieshub/blog">Blog</a></li>
                <li><a href="/sonnieshub/about">About</a></li>
                <li><a href="/sonnieshub/contact">Contact</a></li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li><a href="/sonnieshub/register">Register</a></li>
                    <li><a href="/sonnieshub/login">Login</a></li>
                <?php else : ?>
                    <li><a href="/sonnieshub/dashboard">Dashboard</a></li>
                    <li><a href="/sonnieshub/logout">Logout</a></li>
                    <li id="lg-bag"><a href="/sonnieshub/cart"><i class="far fa-shopping-bag"></i></a></li>
                <?php endif ?>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="/sonnieshub/cart"><i class="far fa-shopping-bag"></i></a>
            <a href="#" id="bar"><i id="bar" class="fas fa-outdent"></i></a>
        </div>
    </section>