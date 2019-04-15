<?php
require 'database.php';

$name = $_POST['name'];
$school = $_POST['school'];
$is_competitor = $_POST['isCompetitor'];
$is_grader = $_POST['isGrader'];
$is_supervisor = $_POST['isSupervisor'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO users (name, school, isCompetitor, isGrader, isSupervisor, username, password)
        VALUES ('$name', '$school', '$is_competitor', '$is_grader', '$is_supervisor', '$username', '$password')";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo $mysqli->error;
}
?>
