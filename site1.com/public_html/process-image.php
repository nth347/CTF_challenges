<?php
session_start();

if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header('location: index.php');
    exit();
}

if (isset($_FILES['file']) && $_FILES['file']['size'] !== 0) {
    $errors = array();

    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp  = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    // Validate the file extension
    $array = explode('.', $_FILES['file']['name']);
    $file_ext = strtolower(end($array));
    $extensions = array('gif');
    if (in_array($file_ext, $extensions) === false) {
        $errors[] = 'File extension not allowed.';
    }

    // Validate the size
    if ($file_size > (10 * 1024 * 1024)) {
        $errors[] = 'File size must be less than 10 MB.';
    }

    if (empty($errors) == true) {
        $uploaded_filename = basename($file_name);
        move_uploaded_file($file_tmp, 'uploads/' . $uploaded_filename);

        // Re-create an image
        $gif = imagecreatefromgif('uploads/' . $uploaded_filename);
        imagegif($gif, 'uploads/' . $_SESSION['username'] . '.gif');
        imagedestroy($gif);
        unlink('uploads/' . $uploaded_filename);

        echo '<p>Image uploaded</p>';
        echo '<a href="index.php">Come back to home page</a>';
    }
    else {
        exit('File is not valid');
    }
} else {
    exit('<p>Oops! Something went wrong. Please try again later.</p>');
}
