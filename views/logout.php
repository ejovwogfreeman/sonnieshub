<?php

session_start();
$_SESSION['user_id'] === false;
$_SESSION['msg'] = 'You have logged out successfully, Login to continue shopping!';
header('Location: login');
// session_destroy();
