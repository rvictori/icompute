<?php
require 'database.php';

$id = $_POST['id'];

$sql = "DELETE FROM users
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
