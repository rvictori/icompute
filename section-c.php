<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_competitor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Section C: Scratch Exam | iCompute</title>

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
          <!-- Heading -->
          <h1>iCompute</h1>
          <h2>Competition Exam</h2>

          <div v-if="!testStarted">
            <img src="_resources/images/blocks-banner.jpg" alt="Section C Banner" />
            <h3>Section C: Scratch</h3>

            <hr />

            <div v-if="hasTaken">
              <div class="callout primary">
                <p>You have taken this part of the test already and may not take it again. Thank you for competing in this year's iCompute competition. You may now <strong>log out</strong> your account.</p>
              </div>
            </div>
            <div v-if="jQuery.isEmptyObject(question)">
              <div class="callout alert">
                <h4>Contact Supervisor</h4>
                <p>It appears there is no assigned test for your team. <strong>Please contact the supervisor to resolve this problem.</strong>
              </div>
            </div>
            <div v-else>
              <button class="button large expanded" v-on:click="startTest">Start Exam</button>
            </div>
          </div>
          <div v-else>
            <h3>Section C: Scratch</h3>

            <hr />

            <h4>Requirements</h4>

            <p style="white-space: pre-wrap;">{{ question.question }}</p>

            <div v-for="currentContent in fetchedQuestionContent" v-if="currentContent.questionId == question.id">
              <img :src="getImageById(currentContent.imageId).path" :alt="getImageById(currentContent.imageId).description" /><br /><br />
            </div>

            <h4>Submission</h4>

            <form id="adding-submission-form" action="/_resources/php/section-c/adding-submission.php" method="post" enctype="multipart/form-data">
              <label for="new-file">File Uploader</label>
              <input type="file" name="new-file" />

              <label for="new-comments">Comments</label>
              <input type="text" name="new-comments" />

              <!-- Save Button -->
              <button class="button success" title="Submit your submission."><i class="far fa-save fa-lg"></i></button>
            </form>
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
        fetchedQuestions: [],
        fetchedQuestionTeams: [],
        fetchedQuestionContent: [],
        fetchedImages: [],
        fetchedSubmissions: [],

        question: {},

        testStarted: false,
        hasTaken: false
      },

      methods: {
        getImageById: function(id) {
          var image = {};

          for (var i = 0; i < this.fetchedImages.length; i++) {
            if (this.fetchedImages[i].id == id) {
              image = this.fetchedImages[i];
            }
          }

          return image;
        },

        startTest: function() {
          this.testStarted = true;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_c_question_teams", this.fetchedQuestionTeams);
        fetchData("section_c_question_content", this.fetchedQuestionContent);
        fetchData("section_c_images", this.fetchedImages);
        fetchData("section_c_submissions", this.fetchedSubmissions);
        fetchData("section_c_questions", this.fetchedQuestions);
      },

      watch: {
        fetchedQuestions: function() {
          var id = <?php echo $_SESSION['id']; ?>;
          var questionId = -1;


          for (var i = 0; i < this.fetchedQuestionTeams.length; i++) {
            if (this.fetchedQuestionTeams[i].userId == id) {
              questionId = this.fetchedQuestionTeams[i].questionId;
            }
          }

          for (var i = 0; i < this.fetchedQuestions.length; i++) {
            if (this.fetchedQuestions[i].id == questionId) {
              this.question = this.fetchedQuestions[i];
            }
          }
        },

        fetchedSubmissions: function() {
          var id = <?php echo $_SESSION['id']; ?>;

          for (var i = 0; i < this.fetchedSubmissions.length; i++) {
            if (this.fetchedSubmissions[i].userId == id) {
              this.hasTaken = true;
            }
          }
        }
      }
    });
    </script>
  </body>
</html>
