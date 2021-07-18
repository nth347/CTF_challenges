<?php
session_start();

if ($_SESSION['loggedIn'] === true) {
    header('location: index.php');
    exit();
}

require_once 'pdo.php';

$username = $password = '';
$username_err = $password_err = $login_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter username.';
    } else {
        $username = trim($_POST['username']);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = 'SELECT id, username, password FROM users WHERE username = :username';

        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':username', $param_username);
            $param_username = trim($_POST['username']);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row['id'];
                        $username = $row['username'];
                        $hashed_password = $row['password'];
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION['loggedIn'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;

                            if ($username == 'admin') {
                                $cookie_name = 'flag';
                                $cookie_value = 'y0u_Ar3_Aw3s0m3';
                                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 30 days

                                header('location: admin/index.php');
                                exit();
                            }

                            header('location: index.php');
                            exit();
                        } else {
                            $login_err = 'Invalid username or password.';
                        }
                    }
                } else {
                    $login_err = 'Invalid username or password.';
                }
            } else {
                echo '<p>Oops! Something went wrong. Please try again later.</p>';
            }
            unset($stmt);
        }
    }
    unset($pdo);
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
<h1>Damp Messaging System - User login</h1>
<?php
if (!empty($login_err)) {
    echo '<div' . $login_err . '</div>';
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="username">Username</label><br>
    <input type="text" id="username" name="username" value="<?php echo $username; ?>">
    <span><?php echo $username_err; ?></span><br>

    <label for="password">Password</label><br>
    <input type="password" id="password" name="password">
    <span><?php echo $password_err; ?></span>

    <input type="submit" value="Login" id="login_button"><br>
    <a href="index.php">Back to home</a>
</form>
</body>
</html>
