<?php

session_start();
$_SESSION['user_id'] === false;
session_destroy();
// $_SESSION['msg'] = 'You have logged out successfully, Login to continue shopping!';
header('Location: login');
