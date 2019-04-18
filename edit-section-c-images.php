<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Edit Section C Images | iCompute</title>

    <!-- Styles -->

    <!-- Poppins Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />

    <!-- Foundation -->
    <link rel="stylesheet" href="_resources/css/foundation.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="_resources/css/main.css" />
    <style>
      h1, h2, h3, h4, h5, h6 {
        font-family: Poppins;
      }
    </style>
  </head>

  <body>
    <?php
    include("_resources/php/navigation.php");
    ?>

    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div id="app" class="cell">
          <pre>{{ fetchedImages }}</pre>

          <!-- Create Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Add a New Image</h3>

            <form id="adding-question-image-form" action="/_resources/php/section-c/adding-image.php" method="post" enctype="multipart/form-data">
              <label for="new-image">Image Uploader</label>
              <input type="file" name="new-image" />

              <label for="new-description">Description</label>
              <input type="text" name="new-description" />

              <!-- Save Button -->
              <button class="button success" title="Save this image."><i class="far fa-save fa-lg"></i></button>
            </form>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <h1>iCompute</h1>
          <h2>Administrative Access</h2>

          <img src="/_resources/images/analysis-banner.jpg" alt="Edit Section C Question Images Banner" />

          <h3>Edit Section C Images</h3>

          <hr />

          <!-- Create Button -->
          <button class="button" title="Create a question image." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

          <div class="cell" v-for="fetchedImage in fetchedImages">
            <img :src="fetchedImage.path" alt="fetchedImage.description" />
          </div>

          <!-- Create Button -->
          <button class="button" title="Create a question image." data-open="create-modal" v-if="fetchedImages.length != 0"><i class="fas fa-plus fa-lg"></i></button>
        </div>
      </div>
    </div>

    <!-- JavaScript Files -->

    <!-- jQuery -->
		<script type="text/javascript" src="_resources/js/vendor/jquery-3.3.1.js"></script>

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- Foundation -->
		<script type="text/javascript" src="_resources/js/vendor/foundation.min.js"></script>
		<script type="text/javascript" src="_resources/js/vendor/what-input.js"></script>
		<script>
		$(document).ready(function() {
			$(document).foundation();
		});
		</script>

    <!-- Fetching and Getting Data -->
		<script type="text/javascript" src="_resources/js/managing-data.js"></script>

    <!-- Section Script -->
    <script>
    var app = new Vue({
      el: '#app',

      data: {
        fetchedImages: []
      },

      methods: {
        saveImage: function() {

        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_c_images", this.fetchedImages);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
