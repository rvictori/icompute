<?php
require '../database.php';

$question = $_POST['question'];
$id = $_POST['id'];

$sql = "UPDATE section_c_questions
        SET question = '$question'
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
