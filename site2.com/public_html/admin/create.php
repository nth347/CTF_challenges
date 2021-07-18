<?php
session_start();

if ($_SESSION['username'] !== 'admin') {
    header('location: login.php');
    exit();
}

require_once '../pdo.php';

$title = $content = '';
$title_err = $content_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (preg_match('/sqlmap\/.+/', $_SERVER['HTTP_USER_AGENT'])) {
        exit();
    }

    $input_title = trim($_POST['title']);
    if (empty($input_title)) {
        $title_err = "Please enter a title.";
    } else if (!filter_var($input_title, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z\s]+$/')))) {
        $title_err = 'Please enter a valid title.';
    } else {
        $title = $input_title;
    }

    // Unfiltered, vulnerable parameter
    $content = $_POST['content'];

    $author = trim($_SESSION['username']);

    if (empty($title_err) && empty($content_err)) {
        $sql = "INSERT INTO news (title, author, content) VALUES ('$title', '$author', '$content')";
        if ($pdo->exec($sql)) {
            header('location: dashboard.php');
            exit();
        } else {
            echo 'Oops! Something went wrong. Please try again later.';
        }
    }
    unset($pdo);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a news</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript">
        function checkTitle(){
            var title = document.getElementById("title").value;
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if(xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                    document.getElementById("title_notification").innerHTML = xmlHttp.responseText;
                }
            }
            xmlHttp.open("POST", "title.php");
            xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlHttp.send('title=' + title);
        }
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create a news</h2>
                <p>Please fill this form and submit to add a news to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($title); ?>" id="title" onblur="checkTitle()">
                        <span class="invalid-feedback"><?php echo $title_err;?></span>
                    </div>
                    <span id="title_notification"></span>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($content); ?></textarea>
                        <span class="invalid-feedback"><?php echo $content_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel, back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>