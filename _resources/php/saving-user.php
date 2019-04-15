<?php
require 'database.php';

$name = $_POST['name'];
$school = $_POST['school'];
$is_competitor = $_POST['isCompetitor'];
$is_grader = $_POST['isGrader'];
$is_supervisor = $_POST['isSupervisor'];
$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];

$sql = "UPDATE users
        SET name = '$name',
            school = '$school',
            isCompetitor = '$is_competitor',
            isGrader = '$is_grader',
            isSupervisor = '$is_supervisor',
            username = '$username',
            password = '$password'
        WHERE id = $id";

if ($mysqli->query($sql)) {
  echo "success";
} else {
  echo "error";
}
?>
