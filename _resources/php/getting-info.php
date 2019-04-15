<?php
require 'database.php';

$table_name = $_GET['tableName'];
$sql = "SELECT *
        FROM $table_name";

if ($result = $mysqli->query($sql)) {
  $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($array);
}
?>
