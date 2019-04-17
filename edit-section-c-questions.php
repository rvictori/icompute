<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Edit Section C Questions | iCompute</title>

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
          <!-- Delete Modal -->
          <div class="reveal" id="delete-modal" data-reveal>
            <h3>Confirmation</h3>
            <p>Type <strong>delete</strong> to delete the question.</p>
            <input type="text" name="delete-confirmation" v-model="deleteConfirmation" />

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the delete modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <h1>iCompute</h1>
          <h2>Administrative Access</h2>

          <img src="_resources/images/white-table-banner.jpg" alt="White Table Banner" />

          <h3>Edit Section C Questions</h3>

          <hr />

          <div class="card" v-for="(fetchedQuestion, index) in fetchedQuestions">
            <div class="card-divider">
              Question {{ index }}
            </div>

            <div class="card-section">
              <div>
                <button class="button small" title="Add a bold tag."><strong>B</strong></button>
                <button class="button small" title="Add an italize tag."><i>I</i></button>
                <button class="button small" title="Add an underline tag."><u>U</u></button>
              </div>

              <textarea rows="5" v-model="fetchedQuestion.question"></textarea>

              <h4>Preview</h4>
              <div v-html="fetchedQuestion.question"></div>
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

    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

    <!-- Section Script -->
    <script>
    bkLib.onDomLoaded(function() {
      nicEditors.allTextAreas();
    });

    var app = new Vue({
      el: '#app',

      data: {
        fetchedQuestions: [],

        deleteConfirmation: "",

        newQuestion: {

        }
      },

      methods: {

      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_c_questions", this.fetchedQuestions);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
