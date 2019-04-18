<?php
require '../database.php';

$id = $_POST['id'];

$sql = "DELETE FROM section_c_images
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
