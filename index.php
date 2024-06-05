<?php

session_start(); // Start the session

// Start output buffering
ob_start();

// Get and sanitize the requested URI
$requestUri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

// Remove query string from the URI
$requestUri = strtok($requestUri, '?');

// Define the base path
$basePath = '/sonnieshub';

// Remove the base path from the request URI
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Ensure the requestUri starts with a slash
if ($requestUri === '' || $requestUri === false) {
    $requestUri = '/';
}

// Redirect if there's a trailing slash and it's not the home page
if ($requestUri !== '/' && substr($requestUri, -1) === '/') {
    // Redirect to the same URL without the trailing slash
    header("Location: $basePath" . rtrim($requestUri, '/'));
    exit();
}

// Simple session-based authentication check
function isAuthenticated()
{
    return isset($_SESSION['user']);
}

// Define public routes
$publicRoutes = [
    '/',
    '/shop',
    '/blog',
    '/about',
    '/contact',
    '/register',
    '/login',
    '/forgot_password'
];

// Check if the route is public or requires authentication
$dynamicPublicRoutes = [
    '#^/product/([a-zA-Z0-9]+)$#'
];

$isPublicRoute = in_array($requestUri, $publicRoutes) || array_reduce($dynamicPublicRoutes, function ($carry, $route) use ($requestUri) {
    return $carry || preg_match($route, $requestUri);
}, false);

if (!$isPublicRoute && !isAuthenticated()) {
    error_log('User is not authenticated, redirecting to login');
    header("Location: $basePath/login");
    exit();
}

// Simple routing logic
switch ($requestUri) {
    case '/':
        require 'views/home.php';
        break;
    case '/shop':
        require 'views/shop.php';
        break;
    case '/articles':
        require 'views/blogs.php';
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
    case '/payment':
        require 'views/payment.php';
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
    case '/orders':
        require 'views/orders.php';
        break;
    case '/forgot_password':
        require 'views/forgot_password.php';
        break;
    case '/logout':
        session_destroy();
        header("Location: $basePath/login");
        exit();
        break;
    case '/admin':
        require 'admin/index.php';
        break;
    case '/admin/users':
        require 'admin/users.php';
        break;
    case '/admin/products':
        require 'admin/products.php';
        break;
    case '/admin/blogs':
        require 'admin/blogs.php';
        break;
    case '/admin/upload_product':
        require 'admin/upload_product.php';
        break;
    case '/admin/create_blog':
        require 'admin/create_blog.php';
        break;
    case '/admin/completed_orders':
        require 'admin/completed_orders.php';
        break;
    case '/profile':
        require 'views/profile.php';
        break;
    case '/settings':
        require 'views/settings.php';
        break;
    default:
        // Handle dynamic routes
        if (preg_match('#^/add_to_cart/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $productId = htmlspecialchars($matches[1]);
            require 'views/add_to_cart.php';
        } elseif (preg_match('#^/remove_from_cart/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $productId = htmlspecialchars($matches[1]);
            require 'views/remove_from_cart.php';
        } elseif (preg_match('#^/order_details/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $orderId = htmlspecialchars($matches[1]);
            require 'views/order_details.php';
        } elseif (preg_match('#^/admin/change_order_status/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $orderId = htmlspecialchars($matches[1]);
            require 'admin/change_order_status.php';
        } elseif (preg_match('#^/cancel_order/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $orderId = htmlspecialchars($matches[1]);
            require 'views/cancel_order.php';
        } elseif (preg_match('#^/user_profile/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $userId = htmlspecialchars($matches[1]);
            require 'views/profile.php';
        } elseif (preg_match('#^/product/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $productId = htmlspecialchars($matches[1]);
            require 'views/product.php'; // Ensure this view exists
        } elseif (preg_match('#^/blog/([a-zA-Z0-9]+)$#', $requestUri, $matches)) {
            $blogId = htmlspecialchars($matches[1]);
            require 'views/blog.php';
        } elseif (preg_match('#^/reset_password/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$#', $requestUri, $matches)) {
            $email = htmlspecialchars($matches[1]);
            require 'views/reset_password.php';
        } else {
            require 'views/404.php';
        }
        break;
}

// End output buffering and flush output
ob_end_flush();
