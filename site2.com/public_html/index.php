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
<p>Latest news</p>
<?php
require_once 'pdo.php';

$rows = $pdo->query("SELECT * FROM news");

echo '<table border="1" cellpadding="10">';
echo '<tr><th>Date</th><th>Title</th><th>Content</th><th>Author</th></tr>';
foreach ($rows as $row) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['date_created'])     . '</td>';
    echo '<td>' . htmlspecialchars($row['title'])  . '</td>';
    echo '<td>' . htmlspecialchars($row['content']) . '</td>';
    echo '<td>' . htmlspecialchars($row['author']) . '</td>';
    echo '</tr>';
}
$rows->closeCursor();
?>
</body>
</html>