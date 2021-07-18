<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DVS</title>
    <style>
        .body {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body class="body">
<h1>DVS - Damp Vulnerable Site</h1>
<?php
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    echo '<p>Hello, you are logged in as user <b>' . $_SESSION["username"] . '</b></p>';
    $filename = $_SESSION['username'];
    if (file_exists("uploads/${filename}.gif")) {
        echo '<img src="uploads/' . $filename . '.gif" width="200" alt="Image not available"><br>';
    } else {
        echo '<p>You do not have a picture yet</p>';
    }
    echo '<a href="index.php?action=upload-image.php">Set profile picture</a> | ';
    echo '<a href="index.php?action=change-password.php">Change password</a> | ';
    echo '<a href="index.php?action=logout.php">Log out</a>';

    if(isset($_GET['action'])) {
        $path = $_GET['action'];
        include "$path";
    }
} else {
    echo '<p>Login required.</p>';
    echo '<a href="login.php">Log in</a> | ';
    echo '<a href="register.php">Sign up</a>';
}
?>
</body>
</html>
