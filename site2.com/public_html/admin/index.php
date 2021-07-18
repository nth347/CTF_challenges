<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News</title>
    <style>
        .body {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body class="body">
<h1>News</h1>
<?php
if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
    echo '<p>Hello, you are <b>' . $_SESSION["username"] . '</b></p>';
    echo '<a href="dashboard.php">Dashboard</a>';
} else {
    echo '<p>Login required.</p>';
    echo '<a href="login.php">Log in</a>';
}
?>
</body>
</html>