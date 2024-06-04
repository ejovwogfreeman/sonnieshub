<?php

// require_once('../views/get_cart_items.php');
// include('./partials/header.php');

// if (isset($_SESSION['user'])) {
//     $user = $_SESSION['user'];
//     $userId = $user['user_id'];
// }

if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
    // include('../views/get_cart_items.php');
} else {
    require_once('./views/get_cart_items.php');
}



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

    // Define the pattern to match '/profile/' followed by an ID
    $pattern = '/\/profile\/[0-9a-zA-Z]+$/';

    if (strpos($url, 'admin') !== false) {
        echo '<link rel="stylesheet" href="../css/style.css">';
    } else {
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
                echo '<a href="/sonnieshub"><img src="/images/logo.png" class="logo" alt="" style="border: none; width: 100px"></a>';
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
                    <li id="lg-bag"><a href="/sonnieshub/cart" id="cart-icon"><i class="far fa-shopping-bag"></i><span class="cart-item-num" style="padding-top: 2px"><?php echo isset($uniqueProductIds) ? count($uniqueProductIds) : 0 ?></span></a></li>
                <?php endif ?>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="/sonnieshub/cart" id="cart-icon"><i class="far fa-shopping-bag"></i><span class="cart-item-num"><?php echo isset($uniqueProductIds) ? count($uniqueProductIds) : 0 ?></span></a>
            <a href="#" id="bar"><i id="bar" class="fas fa-outdent"></i></a>
        </div>
    </section>

    <style>
        #lg-bag {
            position: relative;
        }

        #lg-bag .cart-item-num {
            background-color: red;
            color: white;
            position: absolute;
            top: -10px;
            right: -10px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        #mobile {
            position: relative;
        }

        #mobile #cart-icon .cart-item-num {
            background-color: red;
            color: white;
            position: absolute;
            top: -5px;
            right: 50px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        @media (max-width: 799px) {
            #lg-bag .cart-item-num {
                top: -5px;
                right: -5px;
                width: 30px;
                height: 30px;
                font-size: 10px;
            }

            #mobile #cart-icon .cart-item-num {
                top: -5px;
                padding-top: 1px;
                right: 35px;
                width: 15px;
                height: 15px;
                font-size: 10px;
            }
        }
    </style>