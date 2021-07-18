<?php
session_start();

if ($_SESSION['loggedIn'] !== true) {
    exit();
}

if (isset($_GET['username'])) {
    require 'pdo.php';

    $username =  trim($_GET['username']);
    $myUsername = trim($_SESSION['username']);

    $sql = 'SELECT * FROM  users WHERE username LIKE :username AND username != :myusername LIMIT 1';
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":username", $param_username);
        $stmt->bindParam(":myusername", $param_myUsername);

        $param_username = "%$username%";
        $param_myUsername = $myUsername;

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $username = $row['username'];
                if (is_string($username)) {
                    echo htmlspecialchars($username);
                }
            } else {
                exit();
            }
        } else {
            exit();
        }
    }
    unset($stmt);
    unset($pdo);
}