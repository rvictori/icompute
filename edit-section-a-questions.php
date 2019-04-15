<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Edit Section A Questions | iCompute</title>

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

          <!-- Create Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Create a Question</h3>

            <label for="new-question-question">Question</label>
            <input type="text" id="new-question-question" name="new-question-question" v-model="newQuestion.question" />

            <label for="new-question-correct-answer">Correct Answer</label>
            <input type="text" id="new-question-correct-answer" name="new-question-correct-answer" v-model="newQuestion.correctAnswer" />

            <label for="new-question-answer-1">Answer 1</label>
            <input type="text" id="new-question-answer-1" name="new-question-answer-1" v-model="newQuestion.answer1" />

            <label for="new-question-answer-1">Answer 2</label>
            <input type="text" id="new-question-answer-2" name="new-question-answer-2" v-model="newQuestion.answer2" />

            <label for="new-question-answer-1">Answer 3</label>
            <input type="text" id="new-question-answer-3" name="new-question-answer-3" v-model="newQuestion.answer3" />

            <!-- Create Button -->
            <button class="button" v-on:click="addQuestion">Create</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Save Modal -->
          <div class="reveal" id="save-modal" data-reveal>
            <h3>Save {{ saveStatus }}</h3>
            <p>Your save was a {{ saveStatus }}.</p>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the save modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Heading -->
          <h1>iCompute</h1>

          <h2>{{ headingTwo }}</h2>
          <h3>{{ headingThree }}</h3>

          <!-- Create Button -->
          <button class="button" title="Create a question." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

          <!-- Questions Section in Cards -->
          <div class="grid-x grid-padding-x" data-equalizer="question-heading">
            <div class="cell small-12 medium-6 large-6" v-for="(currentQuestion, index) in fetchedQuestions">
              <div class="card">
                <div class="card-divider" data-equalizer="question-edit" data-equalizer-watch="question-heading">
                  <p>{{ currentQuestion.question }}</p>
                </div>

                <div class="card-section" data-equalizer-watch="question-edit">
                  <label :for="'question-' + index">Question</label>
                  <input type="text" :id="'question-' + index" :name="'question-' + index" v-model="currentQuestion.question" />

                  <label :for="'correct-answer-' + index">Correct Answer</label>
                  <input type="text" :id="'correct-answer-' + index" :name="'correct-answer-' + index" v-model="currentQuestion.correctAnswer" />

                  <label :for="'answer-1-' + index">Answer 1</label>
                  <input type="text" :id="'answer-1-' + index" :name="'answer-1-' + index" v-model="currentQuestion.answer1" />

                  <label :for="'answer-2-' + index">Answer 2</label>
                  <input type="text" :id="'answer-2-' + index" :name="'answer-2-' + index" v-model="currentQuestion.answer2" />

                  <label :for="'answer-3-' + index">Answer 3</label>
                  <input type="text" :id="'answer-3-' + index" :name="'answer-3-' + index" v-model="currentQuestion.answer3" />

                  <!-- Save Button -->
                  <div>
                    <button class="button success" title="Save this question." data-open="save-modal" v-if="fetchedQuestions.length != 0" v-on:click="saveQuestion(index)"><i class="far fa-save fa-lg"></i></button>

                    <!-- Delete Button -->
                    <button class="button alert" title="Delete this question." data-open="delete-modal" v-on:click="setDeleteIndex(index)"><i class="fas fa-trash-alt fa-lg"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Create Button -->
          <button class="button" title="Create a question." data-open="create-modal" v-if="fetchedQuestions.length != 0"><i class="fas fa-plus fa-lg"></i></button>

          <!-- No Questions Message -->
          <p v-if="fetchedQuestions.length == 0">No questions are stored.</p>
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

    <!-- Section A Script -->
    <script>
    var app = new Vue({
      el: '#app',

      data: {
        // Headings
        headingTwo: 'Administrative Access',
        headingThree: 'Editing Section A Questions',

        // Questions
        fetchedQuestions: [],

        // Questions to be edited
        editedQuestions: [],

        // Counter for fetchedQuestions
        counter: 0,

        // Index for question to delete
        deleteIndex: -1,

        // Delete confirmation message
        deleteConfirmation: "",

        // New question to be created
        newQuestion: {
          question: "",
          correctAnswer: "",
          answer1: "",
          answer2: "",
          answer3: ""
        },

        // Save status for modal
        saveStatus: ""
      },

      methods: {
        addQuestion: function() {
          postData("_resources/php/section-a/adding-question.php", this.newQuestion, "adding");

          // Reset.
          this.newQuestion = {
            question: "",
            correctAnswer: "",
            answer1: "",
            answer2: "",
            answer3: ""
          };
          this.fetchedQuestions = [];
          fetchData("section_a_questions", this.fetchedQuestions);

          $("div#create-modal").foundation("close"); // Close the create modal.
        },

        deleteQuestion: function(index) {
          let self = this;

          // Get the index of the question to be deleted.
          var id = -1;

          for (var i = 0; i < this.fetchedQuestions.length; i++) {
            if (i == index) {
              id = this.fetchedQuestions[i].id;
            }
          }

          postData("_resources/php/section-a/deleting-question.php", {
            id: id
          }, "deleting");
        },

        saveQuestion: function(index) {
          let self = this; // "this" is not within the scope of AJAX.

          var data = {};

          for (var i = 0; i < this.fetchedQuestions.length; i++) {
            if (i == index) {
              data = this.fetchedQuestions[i];
            }
          }

          console.log("Submitting data...");

          $.ajax({
            type: "POST",
            url: "_resources/php/section-a/submitting-question.php",
            data: data,

            success: function(data) { // Success.
              console.log("...submission success.");

              self.saveStatus = data;
            },

            fail: function() { // Failure.
              console.log("...submission failure.");

              self.saveStatus = "error";
            },

            always: function() { // Always.

            }
          });
        },

        setDeleteIndex: function(index) {
          this.deleteIndex = index;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_a_questions", this.fetchedQuestions);
      },

      watch: {
        deleteConfirmation: function() {
          // Delete the question when the confirmation is "delete"
          if (this.deleteConfirmation == "delete") {
            this.deleteQuestion(this.deleteIndex);

            this.fetchedQuestions.splice(this.deleteIndex, 1);
            this.deleteConfirmation = "";

            $("div#delete-modal").foundation("close"); // Close the delete modal.
          }
        }
      }
    });
    </script>
  </body>
</html>
