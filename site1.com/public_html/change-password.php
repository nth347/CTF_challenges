<?php
// session_start();

if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header('location: index.php');
    exit();
}

require_once 'pdo.php';

$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = trim($_POST['password']);
    if (empty($password)) {
        $password_err = 'Please enter password.';
    }

    if (empty($password_err)) {
        $sql = 'UPDATE users SET password = :password WHERE username = :username';

        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':password', $param_password);
            $stmt->bindParam(':username', $param_username);

            $param_password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $param_username = $_SESSION['username'];

            if ($stmt->execute() === true) {
                header('location: index.php');
            } else {
                echo '<p>Oops! Something went wrong. Please try again later.</p>';
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>
<h2>Change password</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="password">New password</label><br>
    <input type="text" id="password" name="password">

    <input type="submit" value="Change password">
</form>
