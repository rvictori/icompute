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

      .card-product-hover-title {
        font-size: 1.4rem;
        font-weight: 400;
        margin-bottom: 0.2rem;
      }
      .card-product-hover {
        position: relative;
        line-height: 1.2rem;
        transition: all 0.35s ease;

        min-height: 125px;
      }
      .card-product-hover-details {
        -webkit-flex: 1 0 auto;
        -ms-flex: 1 0 auto;
        flex: 1 0 auto;
        padding: 1rem;
      }
      .card-product-hover-details > :last-child {
        margin-bottom: 0;
      }
      .card-product-hover-price {
        margin: 0.5rem 0;
        font-weight: 700;
        color: #1779ba;
        font-size: #1779ba;
      }
      .card-product-hover-icons {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 0.5rem;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }
      .card-product-hover-icons a i {
        display: block;
        font-size: 1.5rem;
        line-height: 2.5rem;
        width: 2.5rem;
        background-color: #fefefe;
        text-align: center;
        color: #0a0a0a;
      }
      .card-product-hover-icons a i:hover {
        background-color: #8a8a8a;
        color: #fefefe;
        cursor: pointer;
      }
      .card-product-hover-icons a {
        margin: 2px;
        opacity: 0;
        -webkit-transform: translateY(50%);
        -ms-transform: translateY(50%);
        transform: translateY(50%);
        transition: all 0.35s ease;
      }
      .card-product-hover:hover a,
      .card-product-hover.hover a {
        transition: all 0.35s ease;
        opacity: 1;
        -webkit-transform: translateX(0);
        -ms-transform: translateX(0);
        transform: translateX(0);
      }
      .card-product-hover:hover a:nth-child(2),
      .card-product-hover.hover a:nth-child(2) {
        transition-delay: 0.1s;
      }
      .card-product-hover:hover a:nth-child(3),
      .card-product-hover.hover a:nth-child(3) {
        transition-delay: 0.2s;
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
          <!-- Create Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Create a Question</h3>

            <label for="new-question-question">Question</label>
            <textarea name="new-question-question" rows="10" v-model="newQuestion.question"></textarea>

            <!-- Create Button -->
            <button class="button" v-on:click="addQuestion">Create</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Edit Modal -->
          <div class="large reveal" id="edit-modal" data-reveal>
            <h3>Edit Question</h3>

            <label for="edited-question-question">Question
              <textarea name="question" rows="10" v-model="fetchedQuestions[editedQuestionIndex].question" v-if="fetchedQuestions[editedQuestionIndex]"></textarea>
            </label>

            <h4>Images</h4>

            <!-- Add Image Button -->
            <button class="tiny button" title="Add an image to this question." v-on:click="changeWantToAddImage()" v-if="!wantToAddImage"><i class="fas fa-plus fa-lg"></i></button>

            <div v-if="wantToAddImage">
              <form id="form" action="_resources/php/section-c/adding-question-image.php" method="post" enctype="multipart/form-data">
                <label for="image">Image Uploader</label>
                <input type="file" name="image" v-model="newQuestionImage" />

                <label for="description">Description</label>
                <input type="text" name="description" />

                <!-- Save Button -->
                <button class="tiny button success" title="Save this image." v-on:click="saveQuestionImage()"><i class="far fa-save fa-lg"></i></button>
              </form>
            </div>

            <div>
              <!-- Save Button -->
              <button class="button success" title="Save this question." data-open="save-modal" v-on:click="saveQuestion()"><i class="far fa-save fa-lg"></i></button>

              <!-- Delete Button -->
              <button class="button alert" title="Delete this question." v-on:click="setDeletedQuestionIndex(index)"><i class="fas fa-trash-alt fa-lg"></i></button>
            </div>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the edit modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Save Modal -->
          <div class="reveal" id="save-modal" data-reveal>
            <h3>Save {{ saveStatus }}</h3>
            <p>Your save was a {{ saveStatus }}.</p>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the save modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

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

          <div v-if="isLoading">
            <img src="_resources/images/loading-icon.gif" alt="Loading..." />
          </div>
          <div v-else>
            <p>You may click the <i class="fas fa-plus fa-lg"></i> button to create a new question. Also, hover over an existing question that you wish to edit or delete.</p>

            <!-- Create Button -->
            <button class="button" title="Create a question." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

            <div id="questions-section" class="grid-x grid-padding-x">
              <div class="cell" v-for="(fetchedQuestion, index) in fetchedQuestions">
                <!-- Source: https://foundation.zurb.com/building-blocks/blocks/card-product-hover.html -->
                <div class="card card-product-hover">
                  <div class="card-product-hover-icons">
                    <!-- Edit Button -->
                    <a title="Edit this question." href="#" data-open="edit-modal" v-on:click="setEditedQuestionIndex(index)"><i class="fas fa-edit"></i></a>

                    <!-- Delete Button -->
                    <a title="Delete this question." href="#"><i class="fas fa-trash-alt"></i></a>
                  </div>

                  <div class="card-product-hover-details">
                    <p style="white-space: pre-wrap;">{{ fetchedQuestion.question }}</p>

                    <h4>Images</h4>

                    <div v-if="fetchedQuestionImages.length != 0">

                    </div>
                    <div v-else>
                      <div class="callout warning">
                        <p>There are no images for this question.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Create Button -->
            <button class="button" title="Create a question." data-open="create-modal" v-if="fetchedQuestions.length != 0"><i class="fas fa-plus fa-lg"></i></button>
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
        fetchedQuestionImages: [],

        editedQuestionIndex: -1,

        deleteConfirmation: "",

        newQuestion: {
          question: ""
        },

        newQuestionImage: "",

        isLoading: true,

        saveStatus: "",

        wantToAddImage: false
      },

      methods: {
        addQuestion: function() {
          postData("_resources/php/section-c/adding-question.php", this.newQuestion, "adding");

          // Reset.
          this.newQuestion = {
            question: ""
          };
          this.fetchedQuestions = [];
          fetchData("section_c_questions", this.fetchedQuestions);
          fetchData("section_c_question_images", this.fetchedQuestionImages);

          $("div#create-modal").foundation("close"); // Close the create modal.
        },

        changeWantToAddImage() {
          this.wantToAddImage = !this.wantToAddImage;
        },

        makeHtmlFriendly: function(string) {
          return string.replace(/\\r\\n/g, "<br />");
        },

        saveQuestion: function() {
          let self = this; // "this" is not within the scope of AJAX.

          var data = this.fetchedQuestions[this.editedQuestionIndex];

          $.ajax({
            type: "POST",
            url: "_resources/php/section-c/saving-question.php",
            data: data,

            success: function(data) { // Success.
              console.log("...submission success.");

              self.saveStatus = "success";

              // Reset.
              self.fetchedQuestions = [];
              fetchData("section_c_questions", self.fetchedQuestions);
            },

            fail: function() { // Failure.
              console.log("...submission failure.");

              self.saveStatus = "failure";
            },

            always: function() { // Always.

            }
          });

        },

        saveQuestionImage: function() {
          // Get the next order number for this test.
          var order = -1;

          console.log(this.fetchedQuestionImages);

          for (var i = 0; i < this.fetchedQuestionImages.length; i++) {
            if (this.fetchedQuestionImages[i].questionId == this.fetchedQuestions[this.editedQuestionIndex].id && this.fetchedQuestionImages[i].order > order) {
              order = this.fetchedQuestionImages[i].order;
            }
          }

          ++order;

          console.log(order);

          var data = new FormData($("#form"));

          postData("_resources/php/section-c/adding-question-image.php", data, "adding");

          // Reset.
          this.newQuestionImage = "";
        },

        setDeletedQuestionIndex: function(index) {

        },

        setEditedQuestionIndex: function(index) {
          this.editedQuestionIndex = index;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_c_questions", this.fetchedQuestions);
        fetchData("section_c_question_images", this.fetchedQuestionImages);

        let self = this; // "this" is not within the scope of setTimeout().
        setTimeout(function() {
          self.isLoading = false;
        }, 1000);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
