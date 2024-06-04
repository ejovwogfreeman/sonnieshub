<?php

// session_start();
// if (isset($_SESSION['user']) === false) {
//     header('Location: /sonnieshub/login');
// }

// // Check if a session is already started before calling session_start()
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// // Get the current URL
// $current_url = $_SERVER['REQUEST_URI'];

// // Define an array of pages that require authentication
// $protected_pages = [
//     '/sonnieshub/dashboard',
//     '/sonnieshub/cart',
//     '/sonnieshub/admin',
//     '/sonnieshub/orders',
//     // Add other pages that require authentication here
// ];

// // Check if the session 'user' is not set and the current URL is in the array of protected pages
// if (!isset($_SESSION['user']) && in_array($current_url, $protected_pages)) {
//     header('Location: /sonnieshub/login');
//     exit(); // Ensure the script stops executing after redirection
// }



// Check if a session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the current URL
$current_url = $_SERVER['REQUEST_URI'];

// Define an array of pages that do not require authentication
$unprotected_pages = [
    '/sonnieshub/',
    '/sonnieshub/shop',
    '/sonnieshub/blog',
    '/sonnieshub/contact',
    '/sonnieshub/about',
    '/sonnieshub/register',
    '/sonnieshub/login',
    // Add other unprotected pages here
];

// Check if the session 'user' is not set and the current URL is not in the array of unprotected pages
if (!isset($_SESSION['user']) && !in_array($current_url, $unprotected_pages)) {
    header('Location: /sonnieshub/login');
    exit(); // Ensure the script stops executing after redirection
}
