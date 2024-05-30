<?php

// // index.php

// // Start output buffering
// ob_start();

// // Get the requested URI
// $requestUri = $_SERVER['REQUEST_URI'];

// // Remove query string from the URI
// $requestUri = strtok($requestUri, '?');

// // Define the base path
// $basePath = '/sonnieshub';

// // Remove the base path from the request URI
// $requestUri = str_replace($basePath, '', $requestUri);

// // Ensure the requestUri starts with a slash
// if ($requestUri === '') {
//     $requestUri = '/';
// }

// // Simple routing logic
// switch ($requestUri) {
//     case '/':
//         require 'views/home.php';
//         break;
//     case '/shop':
//         require 'views/shop.php';
//         break;
//     case '/blog':
//         require 'views/blog.php';
//         break;
//     case '/about':
//         require 'views/about.php';
//         break;
//     case '/contact':
//         require 'views/contact.php';
//         break;
//     case '/dashboard':
//         require 'views/dashboard.php';
//         break;
//     case '/cart':
//         require 'views/cart.php';
//         break;
//     case '/checkout':
//         require 'views/checkout.php';
//         break;
//     case '/add_to_cart':
//         require 'views/add_to_cart.php';
//         break;
//     case '/remove_from_cart':
//         require 'views/remove_from_cart.php';
//         break;
//     case '/increase':
//         require 'views/increase.php';
//         break;
//     case '/decrease':
//         require 'views/decrease.php';
//         break;
//     case '/register':
//         require 'views/register.php';
//         break;
//     case '/login':
//         require 'views/login.php';
//         break;
//     case '/orders':
//         require 'views/orders.php';
//         break;
//     case '/forgot_password':
//         require 'views/forgot_password.php';
//         break;
//     case '/logout':
//         require 'views/logout.php';
//         break;
//     case '/admin':
//         require 'admin/index.php';
//         break;
//     case '/admin/users':
//         require 'admin/users.php';
//         break;
//     case '/admin/products':
//         require 'admin/products.php';
//         break;
//     case '/admin/blogs':
//         require 'admin/blogs.php';
//         break;
//     case '/admin/upload_product':
//         require 'admin/upload_product.php';
//         break;
//     case '/admin/create_blog':
//         require 'admin/create_blog.php';
//         break;
//     case '/profile':
//         require 'views/profile.php';
//         break;
//     case '/settings':
//         require 'views/settings.php';
//         break;
//     case '/change_password':
//         require 'views/change_password.php';
//         break;
//     default:
//         require 'views/404.php';
//         break;
// }

// // End output buffering and flush output
// ob_end_flush();

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
switch (true) {
    case $requestUri === '/':
        require 'views/home.php';
        break;
    case $requestUri === '/shop':
        require 'views/shop.php';
        break;
    case $requestUri === '/blog':
        require 'views/blog.php';
        break;
    case $requestUri === '/about':
        require 'views/about.php';
        break;
    case $requestUri === '/contact':
        require 'views/contact.php';
        break;
    case $requestUri === '/dashboard':
        require 'views/dashboard.php';
        break;
    case $requestUri === '/cart':
        require 'views/cart.php';
        break;
    case $requestUri === '/checkout':
        require 'views/checkout.php';
        break;
    case $requestUri === '/add_to_cart':
        require 'views/add_to_cart.php';
        break;
    case $requestUri === '/remove_from_cart':
        require 'views/remove_from_cart.php';
        break;
    case $requestUri === '/increase':
        require 'views/increase.php';
        break;
    case $requestUri === '/decrease':
        require 'views/decrease.php';
        break;
    case $requestUri === '/register':
        require 'views/register.php';
        break;
    case $requestUri === '/login':
        require 'views/login.php';
        break;
    case $requestUri === '/orders':
        require 'views/orders.php';
        break;
    case $requestUri === '/forgot_password':
        require 'views/forgot_password.php';
        break;
    case $requestUri === '/logout':
        require 'views/logout.php';
        break;
    case $requestUri === '/admin':
        require 'admin/index.php';
        break;
    case $requestUri === '/admin/users':
        require 'admin/users.php';
        break;
    case $requestUri === '/admin/products':
        require 'admin/products.php';
        break;
    case $requestUri === '/admin/blogs':
        require 'admin/blogs.php';
        break;
    case $requestUri === '/admin/upload_product':
        require 'admin/upload_product.php';
        break;
    case $requestUri === '/admin/create_blog':
        require 'admin/create_blog.php';
        break;
    case $requestUri === '/profile':
        require 'views/profile.php';
        break;
    case $requestUri === '/settings':
        require 'views/settings.php';
        break;
    case $requestUri === '/change_password':
        require 'views/change_password.php';
        break;
    default:
        // Handle dynamic routes
        if (preg_match('#^/profile/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $userId = $matches[1];
            require 'views/profile.php';
        } elseif (preg_match('#^/product/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $productId = $matches[1];
            require 'views/product.php';
        } elseif (preg_match('#^/blog/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $blogId = $matches[1];
            require 'views/blog.php';
        } else {
            require 'views/404.php';
        }
        break;
}

// End output buffering and flush output
ob_end_flush();
