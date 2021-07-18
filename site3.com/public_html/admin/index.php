<?php
session_start();

if ($_SESSION['username'] !== 'admin') {
    header('location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">All messages</h2>
                    <a href="../logout.php" class="btn btn-danger pull-right" id="logout_button">Log out</a>
                </div>
                <?php
                require_once '../pdo.php';
                $sql = 'SELECT * FROM pm ORDER BY ID DESC';
                if ($result = $pdo->query($sql)) {
                    if ($result->rowCount() > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>#</th>';
                        echo '<th>Sender</th>';
                        echo '<th>Receiver</th>';
                        echo '<th>Title</th>';
                        echo '<th>Message</th>';
                        echo '<th>Time</th>';
                        echo '<th>Operations</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ($row = $result->fetch()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id'])              . '</td>';
                            echo '<td>' . htmlspecialchars($row['sender'])          . '</td>';
                            echo '<td>' . htmlspecialchars($row['receiver'])        . '</td>';
                            echo '<td>' . htmlspecialchars($row['title'])           . '</td>';
                            echo '<td>' . $row['message']                           . '</td>';
                            echo '<td>' . htmlspecialchars($row['date_created'])    . '</td>';
                            echo '<td>';
                            echo '<a href="read.php?id='    . $row['id'] . '" class="mr-3" title="View message" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="delete.php?id='  . $row['id'] . '" title="Delete message" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';

                        unset($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No news were found.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                unset($pdo);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>