<?php
// session_start();

if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header('location: index.php');
    exit();
}

?>
<h2>Upload an image</h2>
<form action="process-image.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file"/>
    <input type="submit" value="Upload"/>
</form>
