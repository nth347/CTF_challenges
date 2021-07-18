<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DMS</title>
    <style>
        .body {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body class="body">
<h1>DMS - Damp Message System</h1>
<?php
if (isset($_SESSION['loggedIn']) === true) {
    echo '<p>Hello, you are logged in as user <b>' . htmlspecialchars($_SESSION["username"]) . '</b></p>';
    echo '<a href="list-pm.php">Inbox & Sent</a> | ';
    echo '<a href="send-pm.php">Send a message</a> | ';
    echo '<a href="logout.php">Log out</a>';

} else {
    echo '<p>Login required.</p>';
    echo '<a href="login.php">Log in</a> | ';
    echo '<a href="register.php">Sign up</a>';
}
?>
</body>
</html>
