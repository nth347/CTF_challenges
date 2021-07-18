<?php
session_start();

if ($_SESSION['loggedIn'] !== true) {
    header('location: index.php');
    exit();
}

require_once 'pdo.php';

$receiver = $sender = $title = $message = '';
$receiver_err = $title_err = $message_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['receiver']))) {
        $username_err = 'Please enter a receiver.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['receiver']))) {
        $username_err = 'Receiver can only contain letters, numbers, and underscores.';
    } else {
        $sql = 'SELECT id FROM users WHERE username = :receiver AND username != :my_username';
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':receiver', $param_receiver);
            $stmt->bindParam(':my_username', $param_my_username);
            $param_receiver = trim($_POST['receiver']);
            $param_my_username = trim($_SESSION['username']);

            if($stmt->execute()) {
                if($stmt->rowCount() !== 1) {
                    $receiver_err = 'This receiver does not exist.';
                } else {
                    $receiver = trim($_POST['receiver']);
                }
            } else {
                echo '<p>Oops! Something went wrong. Please try again later.</p>';
            }
            unset($stmt);
        }
    }

    if (empty(trim($_POST['message']))) {
        $message_err = 'Please enter a message.';
    } elseif (strlen(trim($_POST['message'])) > 255) {
        $message_err = 'Message can be maximum 255 characters long.';
    } else {
        $message = trim($_POST['message']);
    }

    if (empty(trim($_POST['title']))) {
        $title_err = 'Please enter a title.';
    } elseif (strlen(trim($_POST['title'])) > 50) {
        $title_err = 'Title can be maximum 50 characters long.';
    } else {
        $title = trim($_POST['title']);
    }

    if (empty($receiver_err) && empty($message_err) && empty($title_err)) {
        $sql = 'INSERT INTO pm (sender, receiver, title, message) VALUES (:sender, :receiver, :title, :message)';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':sender', $param_sender);
            $stmt->bindParam(':receiver', $param_receiver);
            $stmt->bindParam(':title', $param_title);
            $stmt->bindParam(':message', $param_message);

            $param_sender = trim($_SESSION['username']);
            $param_receiver = $receiver;
            $param_title = $title;
            $param_message = $message;

            if ($stmt->execute()) {
                header('location: list-pm.php');
                exit();
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
    <script>
        function showResult(str) {
            if (str.length == 0) {
                document.getElementById("search").innerHTML = "";
                document.getElementById("search").style.border = "0px";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search").innerHTML = this.responseText;
                    document.getElementById("search").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET","search-user.php?username=" + str, true);
            xmlhttp.send();
        }
        function removeResult() {
            document.getElementById("search").innerHTML = "";
            document.getElementById("search").style.border = "0px";
        }
    </script>
</head>
<body class="body">
<h1>DMS - Damp Message System</h1>
<p><?php echo 'Hello, ' . htmlspecialchars($_SESSION['username']); ?></p>
<a href="list-pm.php">Inbox & Sent</a> |
<a href="send-pm.php">Send a message</a> |
<a href="logout.php">Log out</a>
<h2>Send a message</h2>
<form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="receiver">Receiver</label><br>
    <input type="text" id="receiver" name="receiver" value="<?php echo htmlspecialchars($receiver); ?>" onkeyup="showResult(this.value)" onblur="removeResult()">
    <div id="search"></div>
    <span><?php echo $receiver_err; ?></span><br>

    <label for="title">Title</label><br>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
    <span><?php echo $title_err; ?></span><br><br>

    <label for="message">Message</label><br>
    <textarea id="message" name="message" cols="100" rows="8"></textarea>
    <span><?php echo $message_err; ?></span>

    <input type="submit" id="login_button" value="Send">
</form>
</body>
</html>