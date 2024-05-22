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
    case '/cart':
        require 'views/cart.php';
        break;
    default:
        require 'views/404.php';
        break;
}

// End output buffering and flush output
ob_end_flush();
