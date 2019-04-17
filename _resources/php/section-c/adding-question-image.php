<?php
require '../database.php';

// Source: https://www.cloudways.com/blog/the-basics-of-file-upload-in-php/
$image_name = $_FILES['image']['name']; // Stores the original filename from the client.
$image_tmp_name = $_FILES['image']['tmp_name']; // Stores the name of the designated temporary file.
$image_error = $_FILES['image']['error']; // Stores any error code resulting from the transfer.

echo "<pre>"; var_dump($image_error); echo "</pre>";
echo "<pre>"; var_dump($_FILES); echo "</pre>";

$path = '_resources/images/section-c/';

$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
$final_image = rand(1000, 1000000).$image_name;

$path = $path.strtolower($final_image);

if (move_uploaded_file($image_tmp_name, $path)) {
  $question_id = $_POST['questionId'];
  $description = $_POST['description'];
  $order = $_POST['order'];

  $sql = "INSERT INTO section_c_question_images (questionId, image, description, section_c_question_images.order)
  VALUES ($question_id, '$path', '$description', $order)";

  if ($mysqli->query($sql)) {
    echo "success";
  } else {
    echo $mysqli->error;
  }
}
?>
