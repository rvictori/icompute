<?php
require '../database.php';

$question_id = $_POST['questionId'];
$user_id = $_POST['userId'];

$sql = "INSERT INTO section_c_question_teams (questionId, userId)
        VALUES ($question_id, $user_id)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
