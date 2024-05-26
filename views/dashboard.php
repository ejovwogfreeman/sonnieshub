<?php

session_start();
include('./partials/header.php');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo $user['user_id'];
} else {
    echo 'no user';
}

?>

<h2>Dashboard Page</h2>

<?php

include('./partials/footer.php');

?>