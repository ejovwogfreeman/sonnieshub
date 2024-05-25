<?php

session_start();
if (isset($_SESSION['user']) && $_SESSION['user'][0]['is_admin'] === "false") {
    header('Location: /a2z_food/404.php');
} else if (!isset($_SESSION['user'])) {
    header('Location: /a2z_food/login.php');
}
