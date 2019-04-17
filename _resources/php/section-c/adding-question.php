<?php
require '../database.php';

$question = $_POST['question'];

$sql = "INSERT INTO section_c_questions (question)
        VALUES ('$question')";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
