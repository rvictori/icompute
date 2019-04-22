<?php
require '../database.php';

session_start();

// Source: https://www.cloudways.com/blog/the-basics-of-file-upload-in-php/
$file_name = basename($_FILES['new-file']['name']); // Stores the original filename from the client.
$file_tmp_name = $_FILES['new-file']['tmp_name']; // Stores the name of the designated temporary file.
// $file_error = $_FILES['new-file']['error']; // Stores any error code resulting from the transfer.

$path = '../../submissions/';

$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$path = $path.strtolower($file_name);

if (move_uploaded_file($file_tmp_name, $path)) {
  $path = str_replace("../../", "_resources/", $path);

  $user_id = $_SESSION['id'];
  $comments = $_POST['new-comments'];
  $comments = str_replace("'", "\'", $comments);

  $sql = "INSERT INTO section_c_submissions (userId, section_c_submissions.path, comments)
  VALUES ($user_id, '$path', '$comments')";

  if ($mysqli->query($sql)) {

  } else {

  }
}

header("Location: ../../../thank-you.php");
?>
