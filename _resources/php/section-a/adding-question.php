<?php
require '../database.php';

$question = $_POST['question'];
$correct_answer = $_POST['correctAnswer'];
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];

$sql = "INSERT INTO section_a_questions (question, correctAnswer, answer1, answer2, answer3)
        VALUES ('$question', '$correct_answer', '$answer1', '$answer2', '$answer3')";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
