<?php
require '../database.php';

$user_id = $_POST['userId'];
$grade = $_POST['grade'];
$comments = $_POST['comments'];
$graderId = $_POST['graderId'];

$sql = "INSERT INTO section_c_grades (userId, grade, comments, graderId)
        VALUES ($user_id, $grade, '$comments', $graderId)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
