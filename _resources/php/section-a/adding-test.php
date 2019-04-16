<?php
require '../database.php';

$name = $_POST['name'];
$year = $_POST['year'];

$sql = "INSERT INTO section_a_tests (name, year)
        VALUES ('$name', '$year')";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
