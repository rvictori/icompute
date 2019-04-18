<?php
require '../database.php';

// Source: https://www.cloudways.com/blog/the-basics-of-file-upload-in-php/
$image_name = basename($_FILES['new-image']['name']); // Stores the original filename from the client.
$image_tmp_name = $_FILES['new-image']['tmp_name']; // Stores the name of the designated temporary file.
// $image_error = $_FILES['new-image']['error']; // Stores any error code resulting from the transfer.

$path = '../../stored/';

$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
$path = $path.strtolower($image_name);

if (move_uploaded_file($image_tmp_name, $path)) {
  $path = str_replace("../../", "_resources/", $path);

  $description = $_POST['new-description'];
  $description = str_replace("'", "\'", $description);

  $sql = "INSERT INTO section_c_images (section_c_images.path, description)
  VALUES ('$path', '$description')";

  if ($mysqli->query($sql)) {

  } else {
    
  }
}

header("Location: ../../../edit-section-c-images.php");
?>
