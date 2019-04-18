<?php
require '../database.php';

// No need to change the path field, since it will never change.
$description = $_POST['description'];
$id = $_POST['id'];

$sql = "UPDATE section_c_images
        SET description = '$description'
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
