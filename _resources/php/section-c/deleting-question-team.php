<?php
require '../database.php';

$question_id = $_POST['questionId'];
$user_id = $_POST['userId'];

$sql = "DELETE FROM section_c_question_teams
        WHERE questionId = $question_id AND userId = $user_id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
