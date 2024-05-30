<?php

session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] === "false") {
    header('Location: /sonnieshub/404.php');
} else if (!isset($_SESSION['user'])) {
    header('Location: /sonnieshub/login.php');
}
