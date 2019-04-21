<?php
require '../database.php';

$question_id = $_POST['questionId'];
$image_id = $_POST['imageId'];

$sql = "DELETE FROM section_c_question_content
        WHERE questionId = $question_id AND imageId = $image_id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
