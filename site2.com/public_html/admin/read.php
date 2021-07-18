<?php
session_start();

if ($_SESSION['username'] !== 'admin') {
    header('location: login.php');
    exit();
}

require_once '../pdo.php';

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $sql = 'SELECT * FROM news WHERE id = :id';

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $param_id);

        $param_id = trim($_GET['id']);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $id = $row['id'];
                $date_created = $row['date_created'];
                $title = $row['title'];
                $content = $row['content'];
                $author = $row['author'];
            } else {
                header('location: error.php');
                exit();
            }
        } else {
            echo 'Oops! Something went wrong. Please try again later.';
        }
    }
    unset($stmt);
    unset($pdo);
} else {
    header('location: error.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read a news</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">Read a news</h1>
                <div class="form-group">
                    <label><b>Id</b></label>
                    <p><?php echo htmlspecialchars($id); ?></p>
                </div>
                <div class="form-group">
                    <label><b>Date created</b></label>
                    <p><?php echo htmlspecialchars($date_created); ?></p>
                </div>
                <div class="form-group">
                    <label><b>Title</b></label>
                    <p><?php echo htmlspecialchars($title); ?></p>
                </div>
                <div class="form-group">
                    <label><b>Content</b></label>
                    <p><?php echo htmlspecialchars($content); ?></p>
                </div>
                <div class="form-group">
                    <label><b>Author</b>></label>
                    <p><?php echo htmlspecialchars($author); ?></p>
                </div>
                <p><a href="dashboard.php" class="btn btn-primary">Cancel, back to Dashboard</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>