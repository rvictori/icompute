<?php
require '../database.php';

$test_id = $_POST['testId'];
$order = $_POST['order'];
$question_id = $_POST['questionId'];

$sql = "INSERT INTO section_a_test_content (testId, section_a_test_content.order, questionId)
        VALUES ($test_id, $order, $question_id)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
