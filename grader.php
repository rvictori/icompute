<?php
session_start();

if (!(isset($_SESSION['id']) || $_SESSION['is_grader'] == "false")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Grader | iCompute</title>

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
          <h1>iCompute</h1>

          <img class="orbit-image" src="_resources/images/supervisor-banner.jpg" alt="Supervisor Department" />

          <h2>Grader Department</h2>

          <hr />

          <h3>Section C</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-12 large-2">
              <p><a class="button alert expanded" title="Go to the Grade Section C page." href="grade-section-c.php"><i class="fas fa-calculator fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Grade Section C page." href="grade-section-c.php">Grading Tests</a></h4>
              <p>View all submissions for Section C and grade each one based on their submitted Scratch file that can be downloaded.</p>
            </div>
          </div>
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

      },

      methods: {

      },

      mounted: function() {
        console.log("App mounted.");
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
