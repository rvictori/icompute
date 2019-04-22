<?php
session_start();

if (!(isset($_SESSION['id']) || $_SESSION['is_supervisor'] == "false")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Supervisor | iCompute</title>

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

          <h2>Supervisor Department</h2>

          <hr />

          <h3>Section A</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-12 large-2">
              <p><a class="button expanded" title="Go to the View Section A Results page." href="view-section-a-results.php"><i class="fas fa-eye fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the View Section A Results page." href="view-section-a-results.php">View Results</a></h4>
              <p>View all the results from all Section A Tests through this page, which includes the scores of each team as well as their individual answers.</p>
            </div>

            <div class="cell small-12 medium-12 large-2">
              <p><a class="button expanded" title="Go to the Editing Section A Questions page." href="edit-section-a-questions.php"><i class="fas fa-question fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Editing Section A Questions page." href="edit-section-a-questions.php">Editing Questions</a></h4>
              <p>Visit the page for editing all the questions for Section A, the multiple choice exam. This includes creating new questions for future tests and setting which answer is the correct answer.</p>
            </div>

            <div class="cell small-12 medium-12 large-2">
              <p><a class="button expanded" title="Go to the Editing Section A Tests page." href="edit-section-a-tests.php"><i class="fas fa-edit fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Editing Section A Tests page." href="edit-section-a-tests.php">Editing Tests</a></h4>
              <p>This is the place where you can edit a certain version of the Section A Tests. This also includes determining which competitive team can take which test and which question should be in each test iteration.</p>
            </div>
          </div>

          <h3>Section C</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-12 large-2">
              <p><a class="button success expanded" title="Go to the Edit Section C Questions page." href="edit-section-c-questions.php"><i class="fas fa-question fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Edit Section C Questions page." href="edit-section-c-questions.php">Edit Questions</a></h4>
              <p>Visit the maker page where you can create new Scratch questions and edit existing ones by changing the requirements and adding images that help the competitors out. This is the place where you can also determine which team can answer which Section C question.</p>
            </div>

            <div class="cell small-12 medium-12 large-2">
              <p><a class="button success expanded" title="Go to the Edit Section C Images page." href="edit-section-c-images.php"><i class="fas fa-images fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Edit Section C Images page." href="edit-section-c-images.php">Edit Images</a></h4>
              <p>Add and delete images that will be associated for a Scratch question. You may also edit the description of each image as it is necessary just in case the browser cannot read the specified image.</p>
            </div>
          </div>

          <h3>Users</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-12 large-2">
              <p><a class="button alert expanded" title="Go to the Editing Users page." href="edit-users.php"><i class="fas fa-users fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-12 large-10">
              <h4><a title="Go to the Editing Users page." href="edit-users.php">Editing Users</a></h4>
              <p>Get a chance to edit a specific team, grader or supervisor with this page. You can change their username, password and even their level of this program from being a regular competitor to being an administrative supervisor.</p>
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
