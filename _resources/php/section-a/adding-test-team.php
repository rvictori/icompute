<?php
require '../database.php';

$test_id = $_POST['testId'];
$user_id = $_POST['userId'];

$sql = "INSERT INTO section_a_test_teams (testId, userId)
        VALUES ($test_id, $user_id)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
