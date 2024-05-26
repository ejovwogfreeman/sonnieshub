<?php

// index.php

// Start output buffering
ob_start();

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

// Simple routing logic
switch ($requestUri) {
    case '/':
        require 'views/home.php';
        break;
    case '/shop':
        require 'views/shop.php';
        break;
    case '/blog':
        require 'views/blog.php';
        break;
    case '/about':
        require 'views/about.php';
        break;
    case '/contact':
        require 'views/contact.php';
        break;
    case '/dashboard':
        require 'views/dashboard.php';
        break;
    case '/cart':
        require 'views/cart.php';
        break;
    case '/checkout':
        require 'views/checkout.php';
        break;
    case '/add_to_cart':
        require 'views/add_to_cart.php';
        break;
    case '/remove_from_cart':
        require 'views/remove_from_cart.php';
        break;
    case '/increase':
        require 'views/increase.php';
        break;
    case '/decrease':
        require 'views/decrease.php';
        break;
    case '/register':
        require 'views/register.php';
        break;
    case '/login':
        require 'views/login.php';
        break;
    case '/cart_endpoints':
        require 'utils/cart_endpoints.php';
        break;
    case '/forgot_password':
        require 'views/forgot_password.php';
        break;
    case '/logout':
        require 'views/logout.php';
        break;
    case '/admin':
        require 'admin/index.php';
        break;
    default:
        require 'views/404.php';
        break;
}

// End output buffering and flush output
ob_end_flush();
