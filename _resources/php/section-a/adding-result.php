<?php
require '../database.php';

$user_id = $_POST['userId'];
$result = $_POST['result'];

$sql = "INSERT INTO section_a_results (userId, result)
        VALUES ($user_id, $result)";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
