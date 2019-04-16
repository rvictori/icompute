<?php
require '../database.php';

$test_id = $_POST['testId'];
$user_id = $_POST['userId'];

$sql = "DELETE FROM section_a_test_teams
        WHERE testId = $test_id AND userId = $user_id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
