<?php
session_start();

if ($_SESSION['loggedIn'] !== true) {
    header('location: index.php');
    exit();
}

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
<p><?php echo 'Hello, ' . htmlspecialchars($_SESSION['username']); ?></p>
<a href="list-pm.php">Inbox & Sent</a> |
<a href="send-pm.php">Send a message</a> |
<a href="logout.php">Log out</a>
<?php
require 'pdo.php';

echo '<h2>Inbox</h2>';
$username = trim($_SESSION['username']);
$sql1 = "SELECT * FROM pm WHERE receiver='$username'";
$received_messages = $pdo->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
if (sizeof($received_messages) !== 0) {
    echo '<table border="0" cellpadding="5">';
    echo '<tr><th>From</th><th>Title</th><th>Message content</th><th>Time</th></tr>';
    foreach ($received_messages as $message) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($message['sender'])          . '</td>';
        echo '<td>' . htmlspecialchars($message['title'])           . '</td>';
        echo '<td>' . htmlspecialchars($message['message'])         . '</td>';
        echo '<td>' . htmlspecialchars($message['date_created'])    . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>You have RECEIVED no message</p>';
}

echo '<h2>Sent</h2>';
$sql2 = "SELECT * FROM pm WHERE sender='$username'";
$sent_messages = $pdo->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
if (sizeof($sent_messages) !== 0) {
    echo '<table border="0" cellpadding="5">';
    echo '<tr><th>To</th><th>Title</th><th>Message content</th><th>Time</th></tr>';
    foreach ($sent_messages as $message) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($message['receiver'])          . '</td>';
        echo '<td>' . htmlspecialchars($message['title'])           . '</td>';
        echo '<td>' . htmlspecialchars($message['message'])         . '</td>';
        echo '<td>' . htmlspecialchars($message['date_created'])    . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>You have SENT no message</p>';
}
?>
</body>
</html>