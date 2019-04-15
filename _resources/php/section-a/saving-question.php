<?php
require '../database.php';

$question = $_POST['question'];
$correct_answer = $_POST['correctAnswer'];
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];
$id = $_POST['id'];

$sql = "UPDATE section_a_questions
        SET question = '$question',
            correctAnswer = '$correct_answer',
            answer1 = '$answer1',
            answer2 = '$answer2',
            answer3 = '$answer3'
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
