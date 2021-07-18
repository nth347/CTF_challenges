<?php
session_start();

if ($_SESSION['loggedIn'] !== true) {
    header('location: index.php');
    exit();
}

setcookie(session_name(), '', 1);
setcookie('flag', '', 1);
session_unset();
session_destroy();

// Redirect to index
header('location: index.php');
exit();
