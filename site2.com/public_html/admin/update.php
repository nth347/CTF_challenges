<?php
session_start();

if ($_SESSION['username'] !== 'admin') {
    header('location: login.php');
    exit();
}

require_once '../pdo.php';

$title = $content = '';
$title_err = $content_err = '';

if (isset($_POST['id']) && !empty($_POST['content'])) {
    $id = trim($_POST['id']);

    $input_title = trim($_POST['title']);
    if (empty($input_title)) {
        $title_err = 'Please enter a title.';
    } elseif (!filter_var($input_title, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z\s]+$/')))) {
        $title_err = 'Please enter a valid title.';
    } else {
        $title = $input_title;
    }

    $input_content = trim($_POST['content']);
    if (empty($input_content)) {
        $content_err = 'Please enter a content.';
    } else {
        $content = $input_content;
    }

    // Check input errors before inserting in database
    if (empty($title_err) && empty($content_err)) {
        $sql = 'UPDATE news SET title=:title, content=:content WHERE id=:id';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':title', $param_title);
            $stmt->bindParam(':content', $param_content);
            $stmt->bindParam(':id', $param_id);

            $param_title = $title;
            $param_content = $content;
            $param_id = $id;

            if ($stmt->execute()) {
                header('location: dashboard.php');
                exit();
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
        }
        unset($stmt);
    }
    unset($pdo);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET['id'])){
        $id =  trim($_GET['id']);

        $sql = 'SELECT * FROM  news WHERE id = :id';
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $param_id);

            $param_id = $id;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $title = $row['title'];
                    $content = $row['content'];
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
    }  else {
        header('location: error.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update a news</title>
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
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the news.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($title); ?>">
                        <span class="invalid-feedback"><?php echo $title_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo htmlspecialchars($content); ?></textarea>
                        <span class="invalid-feedback"><?php echo $content_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Update">
                    <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel, back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>