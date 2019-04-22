<?php
require '../database.php';

$question_id = $_POST['questionId'];
$image_id = $_POST['imageId'];
$order = $_POST['order'];

$sql = "INSERT INTO section_c_question_content (questionId, imageId, section_c_question_content.order)
        VALUES ($question_id, $image_id, $order)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
