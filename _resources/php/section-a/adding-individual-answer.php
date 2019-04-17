<?php
require '../database.php';

$user_id = $_POST['userId'];
$question_id = $_POST['questionId'];
$answer_no = $_POST['answerNo'];

$sql = "INSERT INTO section_a_individual_answers (userId, questionId, answerNo)
        VALUES ($user_id, $question_id, $answer_no)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
