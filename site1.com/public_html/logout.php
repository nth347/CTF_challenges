<?php
// session_start();

setcookie(session_name(), '', 1);
session_unset();
session_destroy();

// Redirect to index page
header('location: index.php');
exit();
