<?php
require '../database.php';

$name = $_POST['name'];
$year = $_POST['year'];
$id = $_POST['id'];

$sql = "UPDATE section_a_tests
        SET name = '$name',
            year = '$year'
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
