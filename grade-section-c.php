<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_grader'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Grade Section C | iCompute</title>

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
          <!-- Grade Modal -->
          <div class="large reveal" id="grade-modal" data-reveal>
            <div v-if="selectedTest">
              <h3>Grade Test</h3>

              <p>You may view the graded submissions here. A team not having a score means it has not been graded yet. Hover over the team to click on the <i class="fas fa-calculator"></i> button to grade them.</p>

              <div v-if="selectedSubmissions.length != 0">
                <div class="grid-x grid-padding-x">
                  <div class="cell" v-for="selectedSubmission in selectedSubmissions">
                    <div v-if="hasGrade(selectedSubmission)">
                      <div class="card card-product-hover">
                        <div class="card-product-hover-details">
                          <h6>{{ getUserById(selectedSubmission.userId).name }}</h6>

                          <div class="grid-x">
                            <div class="cell small-12 medium-6 large-6">
                              <p>Score: {{ getGradeById(selectedSubmission.userId).grade }}</p>
                            </div>

                            <div class="cell small-12 medium-6 large-6">
                              <p>Grader: {{ getUserById(getGradeById(selectedSubmission.userId).graderId).name }}</p>
                            </div>
                          </div>

                          <p v-if="getGradeById(selectedSubmission.userId).comments">Comments:<br />{{ getGradeById(selectedSubmission.userId).comments }}</p>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="card card-product-hover">
                        <div class="card-product-hover-icons">
                          <!-- Grade Button -->
                          <a title="Grade this user." href="#" data-open="grade-user-modal" v-on:click="setSelectedSubmission(selectedSubmission)"><i class="fas fa-calculator"></i></a>
                        </div>

                        <div class="card-product-hover-details">
                          <h6>{{ getUserById(selectedSubmission.userId).name }}</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="callout primary">
                  <p>No one has submitted this specific test.</p>
                </div>
              </div>
            </div>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the grade modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Grade User Modal -->
          <div class="reveal" id="grade-user-modal" data-reveal>
            <h3>Grade Team</h3>

            <h4>Submission</h4>
            <p><a class="button small " title="Download the submission file." :href="selectedSubmission.path" target="_blank">Download Scratch File</a></p>

            <h4>Grade</h4>

            <label for="grade">Grade
              <input type="text" name="grade" v-model="newGrade.grade" />
            </label>

            <label for="comments">Comments
              <input type="text" name="comments" v-model="newGrade.comments" />
            </label>

            <!-- Save Button -->
            <button class="button success" title="Save this grade." data-open="save-modal" v-on:click="addGrade"><i class="far fa-save fa-lg"></i></button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the grade user modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Heading -->
          <h1>iCompute</h1>
          <h2>Grading Access</h2>

          <img src="_resources/images/subjects-banner.jpg" alt="Grade Section C Banner" />

          <h3>Grade Section C</h3>

          <hr />

          <p>Select a test you would like to grade.</p>

          <div class="grid-x grid-padding-x">
            <div class="cell" v-for="fetchedQuestion in fetchedQuestions">
              <div class="card card-product-hover">
                <div class="card-product-hover-icons">
                  <!-- Grade Button -->
                  <a title="Grade this test." href="#" data-open="grade-modal" v-on:click="setSelectedTest(fetchedQuestion)"><i class="fas fa-calculator"></i></a>
                </div>

                <div class="card-product-hover-details">
                  <p style="white-space: pre-wrap;">{{ fetchedQuestion.question }}</p>
                </div>
              </div>
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
        fetchedQuestions: [],
        fetchedQuestionTeams: [],
        fetchedSubmissions: [],
        fetchedGrades: [],
        fetchedUsers: [],

        selectedTest: {},
        selectedSubmissions: [],
        selectedSubmission: {},

        newGrade: {
          grade: null,
          comments: ""
        }
      },

      methods: {
        addGrade: function() {
          postData("_resources/php/section-c/adding-grade.php", {
            userId: this.selectedSubmission.userId,
            grade: this.newGrade.grade,
            comments: this.newGrade.comments,
            graderId: <?php echo $_SESSION['id']; ?>
          }, "adding");

          // Reset.
          this.fetchedGrades = [];
          fetchData("section_c_grades", this.fetchedGrades);

          $("div#grade-user-modal").foundation("close"); // Close the grade user modal.
          $("div#grade-modal").foundation("open"); // Open the previous modal, the grade modal.
        },

        getGradeById: function(id) {
          var grade = {};

          for (var i = 0; i < this.fetchedGrades.length; i++) {
            if (this.fetchedGrades[i].userId == id) {
              grade = this.fetchedGrades[i];
            }
          }

          return grade;
        },

        getUserById: function(id) {
          var user = {};

          for (var i = 0; i < this.fetchedUsers.length; i++) {
            if (this.fetchedUsers[i].id == id) {
              user = this.fetchedUsers[i];
            }
          }

          return user;
        },

        hasGrade: function(submission) {
          var hasGrade = false;

          for (var i = 0; i < this.fetchedGrades.length; i++) {
            if (this.fetchedGrades[i].userId == submission.userId) {
              hasGrade = true;
            }
          }

          return hasGrade;
        },

        setSelectedSubmission: function(selectedSubmission) {
          this.selectedSubmission = selectedSubmission;
        },

        setSelectedTest: function(selectedTest) {
          this.selectedTest = selectedTest;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_c_question_teams", this.fetchedQuestionTeams);
        fetchData("section_c_submissions", this.fetchedSubmissions);
        fetchData("section_c_grades", this.fetchedGrades);
        fetchData("users", this.fetchedUsers);
        fetchData("section_c_questions", this.fetchedQuestions);
      },

      watch: {
        selectedTest: function() {
          this.selectedSubmissions = [];

          if (this.selectedTest) {
            for (var i = 0; i < this.fetchedSubmissions.length; i++) {
              var userId = this.fetchedSubmissions[i].userId;

              for (var j = 0; j < this.fetchedQuestionTeams.length; j++) {
                if (this.fetchedQuestionTeams[j].userId == userId && this.fetchedQuestionTeams[j].questionId == this.selectedTest.id) {
                  this.selectedSubmissions.push(this.fetchedSubmissions[i]);
                  break;
                }
              }
            }
          }
        }
      }
    });
    </script>
  </body>
</html>
