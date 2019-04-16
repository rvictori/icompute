<?php
require '../database.php';

$test_id = $_POST['testId'];
$order = $_POST['order'];
$question_id = $_POST['questionId'];

$sql = "DELETE FROM section_a_test_content
        WHERE testId = $test_id AND section_a_test_content.order = $order AND questionId = $question_id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
