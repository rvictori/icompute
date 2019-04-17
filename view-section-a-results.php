<?php
session_start();

if (!(isset($_SESSION['id'])) || $_SESSION['is_supervisor'] == "false") { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>View Section A Results | iCompute</title>

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
          <h2>{{ headingTwo }}</h2>

          <div v-if="isLoading">
            <img src="_resources/images/loading-icon.gif" alt="Loading..." />
          </div>
          <div v-else>
            <img src="_resources/images/sunset.jpg" alt="Sunset Banner" />

            <h3>{{ headingThree }}</h3>

            <hr />

            <div v-for="test in fetchedTests">
              <h4>{{ test.name }} ({{ test.year }})</h4>
              <p><a class="button small" title="Download the results in CSV for this test." :href="getCsvFile(test.id)" download="results.csv">Download CSV</a></p>

              <div class="callout">
                <div v-for="team in fetchedTestTeams" v-if="team.testId == test.id">
                  <div v-if="!getElement(fetchedResults, 'userId', team.userId, 'result')">
                    <h5>{{ getElement(fetchedUsers, 'id', team.userId, 'name') }}</h5>

                    <div class="callout primary">
                      <p>This team has not taken this test yet.</p>
                    </div>
                  </div>
                  <div v-else>
                    <h5>{{ getElement(fetchedUsers, 'id', team.userId, 'name') }} | Score: {{ getElement(fetchedResults, 'userId', team.userId, 'result') }}</h5>

                    <div v-for="individualAnswer in fetchedIndividualAnswers" v-if="individualAnswer.userId == team.userId">
                      <p>{{ getElement(fetchedQuestions, 'id', individualAnswer.questionId, 'question') }}</p>

                      <div class="callout success" v-if="getAnswer(fetchedQuestions, 'id', individualAnswer.questionId, individualAnswer.answerNo) == getElement(fetchedQuestions, 'id', individualAnswer.questionId, 'correctAnswer')">
                        <p><strong>Selected Correct Answer</strong>: {{ getAnswer(fetchedQuestions, 'id', individualAnswer.questionId, individualAnswer.answerNo) }}</p>
                      </div>
                      <div v-else>
                        <div class="callout warning" v-if="individualAnswer.answerNo == -1">
                          <p>No answer was selected.</p>
                        </div>
                        <div class="callout alert" v-else>
                        <p><strong>Selected Wrong Answer</strong>: {{ getAnswer(fetchedQuestions, 'id', individualAnswer.questionId, individualAnswer.answerNo) }}</p>
                      </div>
                    </div>
                  </div>
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
        // Headings
        headingTwo: "Administrative Access",
        headingThree: "View Section A Results",

        fetchedIndividualAnswers: [],

        fetchedTests: [],

        fetchedTestTeams: [],

        fetchedQuestions: [],

        fetchedResults: [],

        fetchedUsers: [],

        isLoading: true
      },

      methods: {
        getAnswer: function(array, arrayVar, checkVar, key) {
          var answerKey;

          if (key == 0) {
            answerKey = "correctAnswer";
          } else {
            answerKey = "answer" + key;
          }

          return this.getElement(array, arrayVar, checkVar, answerKey);
        },

        getCsvFile: function(testId) {
          var content = "name,school,result\n";

          for (var i = 0; i < this.fetchedResults.length; i++) {
            var currentUserId = this.fetchedResults[i].userId;

            var isTakingTest = false;

            for (var j = 0; j < this.fetchedTestTeams.length; j++) {
              if (this.fetchedTestTeams[j].userId == currentUserId) {
                isTakingTest = this.fetchedTestTeams[i].testId == testId;
              }
            }

            if (isTakingTest) {
              var user = {};

              for (var j = 0; j < this.fetchedUsers.length; j++) {
                if (this.fetchedUsers[j].id == currentUserId) {
                  user = this.fetchedUsers[j];


                }
              }

              content += user.name + "," + user.school + "," + this.fetchedResults[i].result + "\n";
            }
          }

          console.log(content);

          return encodeURI("data:text/csv;charset=utf-8," + content);
        },

        getElement: function(array, arrayVar, checkVar, key) {
          var element;

          for (var i = 0; i < array.length; i++) {
            if (array[i][arrayVar] == checkVar) {
              element = array[i][key];
            }
          }

          return element;
        },
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_a_individual_answers", this.fetchedIndividualAnswers);

        fetchData("section_a_tests", this.fetchedTests);

        fetchData("section_a_test_teams", this.fetchedTestTeams);

        fetchData("section_a_questions", this.fetchedQuestions);

        fetchData("section_a_results", this.fetchedResults);

        fetchData("users", this.fetchedUsers);

        let self = this; // "this" is not within the scope of setTimeout().
        setTimeout(function() {
          self.isLoading = false;
        }, 2000);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
