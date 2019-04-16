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
          <h3>{{ headingThree }}</h3>

          <div v-for="test in fetchedTests">
            <h4>{{ test.name }} ({{ test.year }})</h4>
            <p><a class="button small" title="Download the results in CSV for this test." :href="getCsvFile(test.id)" download="results.csv">Download CSV</a></p>

            <div class="callout">
              <div v-for="team in fetchedTestTeams" v-if="team.testId == test.id">
                <div v-if="!getFetchedResultInfo(team.userId, 'result')">
                  <h5>{{ getFetchedUserInfo(team.userId, 'name') }}</h5>

                  <div class="callout primary">
                    <p>This team has not taken this test yet.</p>
                  </div>
                </div>
                <div v-else>
                  <h5>{{ getFetchedUserInfo(team.userId, 'name') }} | Score: {{ getFetchedResultInfo(team.userId, 'result') }}</h5>

                  <div v-for="individualAnswer in fetchedIndividualAnswers" v-if="individualAnswer.userId == team.userId">
                    <p>{{ getFetchedQuestionInfo(individualAnswer.questionId, 'question') }}</p>

                    <div class="callout success" v-if="individualAnswer.answer == getFetchedQuestionInfo(individualAnswer.questionId, 'correctAnswer')">
                      <p><strong>Selected Correct Answer</strong>: {{ individualAnswer.answer }}</p>
                    </div>
                    <div class="callout alert" v-else>
                      <p><strong>Selected Wrong Answer</strong>: {{ individualAnswer.answer }}</p>
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

        fetchedUsers: []
      },

      methods: {
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
                if (this.fetchedUsers[i].id == currentUserId) {
                  user = this.fetchedUsers[i];
                }
              }

              content += user.name + "," + user.school + "," + this.fetchedResults[i].result + "\n";
            }
          }

          console.log(content);

          return encodeURI("data:text/csv;charset=utf-8," + content);
        },

        getFetchedQuestionInfo: function(questionId, key) {
          for (var i = 0; i < this.fetchedQuestions.length; i++) {
            if (this.fetchedQuestions[i].id == questionId) {
              return this.fetchedQuestions[i][key];
            }
          }
        },

        getFetchedResultInfo: function(userId, key) {
          for (var i = 0; i < this.fetchedResults.length; i++) {
            if (this.fetchedResults[i].userId == userId) {
              return this.fetchedResults[i][key];
            }
          }
        },

        getFetchedUserInfo: function(userId, key) {
          for (var i = 0; i < this.fetchedUsers.length; i++) {
            if (this.fetchedUsers[i].id == userId) {
              return this.fetchedUsers[i][key];
            }
          }
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData("section_a_individual_answers", this.fetchedIndividualAnswers);

        fetchData("section_a_tests", this.fetchedTests);

        fetchData("section_a_test_teams", this.fetchedTestTeams);

        fetchData("section_a_questions", this.fetchedQuestions);

        fetchData("section_a_results", this.fetchedResults);

        fetchData("section_a_users", this.fetchedUsers);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
