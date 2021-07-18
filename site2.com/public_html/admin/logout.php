<?php
session_start();

setcookie(session_name(), '', 1);
session_unset();
session_destroy();

// Redirect to index
header('location: index.php');
exit();