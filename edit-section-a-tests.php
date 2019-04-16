<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Edit Section A Tests | iCompute</title>

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
            <p>Type <strong>delete</strong> to delete the {{ deleteItemType }}.</p>
            <input type="text" name="delete-confirmation" v-model="deleteConfirmation" />

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the delete modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Add Question Modal -->
          <div class="reveal" id="add-test-content-modal" data-reveal>
            <h3>Adding a Question</h3>
            <p>Pick a question you want to add.</p>

            <select v-model="addedQuestionId">
              <option v-for="question in fetchedQuestions" :value="question.id">{{ question.question }}</option>
            </select>

            <!-- Create Button -->
            <button class="button" v-on:click="addTestContent">Add</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the add modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Add Team Modal -->
          <div class="reveal" id="add-test-team-modal" data-reveal>
            <h3>Adding a Team</h3>
            <p>Pick a team you want to add.</p>

            <select v-model="addedTeamId">
              <option v-for="user in fetchedUsers" v-if="user.isCompetitor == 'true'" :value="user.id">{{ user.name }}</option>
            </select>

            <!-- Create Button -->
            <button class="button" v-on:click="addTeam">Add</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the add modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Create a Test Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Create a Test</h3>

            <label for="new-test-name">Name</label>
            <input type="text" id="new-test-name" name="new-test-name" v-model="newTest.name" />

            <label for="new-test-year">Year</label>
            <input type="text" id="new-test-year" name="new-test-year" v-model="newTest.year" />

            <!-- Create Button -->
            <button class="button" v-on:click="addTest">Create</button>

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
          <button class="button" title="Create a test." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

          <!-- Tests Section -->
          <div class="card" v-for="(test, index) in fetchedTests">
            <div class="card-divider">
              <p>{{ test.name }} <span v-if="test.year">({{ test.year }})</span></p>
            </div>

            <div class="card-section">
              <h5>Details</h5>

              <label :for="'name-' + index">Name</label>
              <input type="text" :id="'name-' + index" :name="'name-' + index" v-model="test.name" />

              <label :for="'year-' + index">Year</label>
              <input type="text" :id="'year-' + index" :name="'year-' + index" v-model="test.year" />

              <div class="grid-x grid-padding-x">
                <!-- Questions -->
                <div class="cell small-12 medium-6 large-6">
                  <h5>Questions</h5>

                  <!-- Add Question Button -->
                  <button class="tiny button" title="Add a question." data-open="add-test-content-modal" v-on:click="setAdd(test.id)"><i class="fas fa-plus fa-lg"></i></button>

                  <div class="callout primary" v-for="(content, contentIndex) in fetchedTestContent" v-if="test.id == content.testId">
                    <p>{{ getQuestion(content.questionId) }}</p>

                    <!-- Delete Question Button -->
                    <button class="tiny button alert" title="Delete this question." data-open="delete-modal" v-on:click="setDelete(contentIndex, 'question')"><i class="fas fa-times fa-lg"></i></button>
                  </div>
                </div>

                <!-- Teams -->
                <div class="cell small-12 medium-6 large-6">
                  <h5>Teams</h5>

                  <!-- Add Team Button -->
                  <button class="tiny button" title="Add a team." data-open="add-test-team-modal" v-on:click="setAdd(test.id)"><i class="fas fa-plus fa-lg"></i></button>

                  <div class="callout success" v-for="(team, teamIndex) in fetchedTestTeams" v-if="test.id == team.testId">
                    <p>{{ getTeam(team.userId) }}</p>

                    <!-- Delete Team Button -->
                    <button class="tiny button alert" title="Delete this team." data-open="delete-modal" v-on:click="setDelete(teamIndex, 'team')"><i class="fas fa-times fa-lg"></i></button>
                  </div>
                </div>

                <div class="cell">
                  <!-- Save Button -->
                  <button class="button success" title="Save tests." data-open="save-modal" v-on:click="saveTest(index)"><i class="far fa-save fa-lg"></i></button>

                  <!-- Delete Button -->
                  <button class="button alert" title="Delete this test." data-open="delete-modal" v-on:click="setDelete(index, 'test')"><i class="fas fa-trash-alt fa-lg"></i></button>
                </div>
              </div>
            </div>
          </div>

          <!-- Create Button -->
          <button class="button" title="Create a test." data-open="create-modal" v-if="fetchedTests.length != 0"><i class="fas fa-plus fa-lg"></i></button>
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
        headingTwo: 'Administrative Access',
        headingThree: 'Editing Section A Tests',

        // Get all test versions.
        fetchedTests: [],

        // Get content for all test versions.
        fetchedTestContent: [],

        // Get all questions.
        fetchedQuestions: [],

        // Get all information on which team is taking which test.
        fetchedTestTeams: [],

        // Get all users
        fetchedUsers: [],

        // What type of item to delete for output.
        deleteItemType: "",

        // The index of the item to delete.
        deleteIndex: -1,

        // The confirmation input of deletion.
        deleteConfirmation: "",

        // The index of the test that a question needs to be added to.
        addedTestId: -1,

        // The index of the question to be added.
        addedQuestionId: 1,

        // The index of the team to be added.
        addedTeamId: 1,

        saveStatus: "",

        // Variables for New Test
        newTest: {
          name: "",
          year: ""
        },
      },

      methods: {
        addTeam: function() {
          var testTeam = {
            testId: this.addedTestId,
            userId: this.addedTeamId
          };

          postData("_resources/php/section-a/adding-test-team.php", testTeam, "adding");

          // Reset.
          this.addedTeamId = 1;
          this.fetchedTestTeams = [];
          fetchData("section_a_test_teams", this.fetchedTestTeams);

          $("div#add-test-team-modal").foundation("close"); // Close the add modal.
        },

        addTest: function() {
          postData("_resources/php/section-a/adding-test.php", this.newTest, "adding");

          // Reset.
          this.newTest = {
            name: "",
            year: ""
          };
          this.fetchedTests = [];
          fetchData("section_a_tests", this.fetchedTests);

          $("div#create-modal").foundation("close"); // Close the create modal.
        },

        addTestContent: function() {
          var testContent = {
            testId: this.addedTestId,
            order: -1,
            questionId: this.addedQuestionId
          };

          // Get the next order number for this test.
          for (var i = 0; i < this.fetchedTestContent.length; i++) {
            if (this.fetchedTestContent[i].testId == this.addedTestId && testContent.order < this.fetchedTestContent[i].order) {
              testContent.order = this.fetchedTestContent[i].order;
            }
          }

          ++testContent.order;

          postData("_resources/php/section-a/adding-test-content.php", testContent, "adding");


          // Reset.
          this.addedQuestionId = 1;
          this.fetchedTestContent = [];
          fetchData("section_a_test_content", this.fetchedTestContent);

          $("div#add-test-content-modal").foundation("close"); // Close the add modal.
        },

        deleteTest: function(index) {
          // Get the ID of the test to be deleted.
          var id = -1;

          for (var i = 0; i < this.fetchedTests.length; i++) {
            if (i == index) {
              id = this.fetchedTests[i].id;
            }
          }

          postData("_resources/php/section-a/deleting-test.php", {
            id: id
          }, "deleting");
        },

        deleteTestContent: function(index) {
          // Get the test content to be deleted.
          var data = {};

          for (var i = 0; i < this.fetchedTestContent.length; i++) {
            if (i == index) {
              data = this.fetchedTestContent[i];
            }
          }

          postData("_resources/php/section-a/deleting-test-content.php", data, "deleting");
        },

        deleteTestTeam: function(index) {
          // Get the test team to be deleted.
          var data = {};

          for (var i = 0; i < this.fetchedTestTeams.length; i++) {
            if (i == index) {
              data = this.fetchedTestTeams[i];
            }
          }

          postData("_resources/php/section-a/deleting-test-team.php", data, "deleting");
        },

        getQuestion: function(questionId) {
          var question = "";

          for (var i = 0; i < this.fetchedQuestions.length; i++) {
            if (this.fetchedQuestions[i].id == questionId) {
              question = this.fetchedQuestions[i].question;
            }
          }

          return question;
        },

        getTeam: function(userId) {
          var teamName = "";

          for (var i = 0; i < this.fetchedUsers.length; i++) {
            if (this.fetchedUsers[i].id == userId) {
              teamName = this.fetchedUsers[i].name;
            }
          }

          return teamName;
        },

        saveTest: function(index) {
          let self = this; // "this" is not within the scope of AJAX.

          var data = {};

          for (var i = 0; i < this.fetchedTests.length; i++) {
            if (i == index) {
              data = this.fetchedTests[i];
            }
          }

          console.log("Submitting data...");

          $.ajax({
            type: "POST",
            url: "_resources/php/section-a/saving-test.php",
            data: data,

            success: function(data) { // Success.
              console.log("...submission success.");

              self.saveStatus = data;
            },

            fail: function() { // Failure.
              console.log("...submission failure.");

              self.saveStatus = "failure";
            },

            always: function() { // Always.

            }
          });
        },

        setAdd: function(index) {
          this.addedTestId = index;
        },

        setDelete: function(index, type) {
          this.deleteIndex = index;
          this.deleteItemType = type;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        // Fetch all the test versions.
        fetchData("section_a_tests", this.fetchedTests);

        // Fetch the content for all test versions.
        fetchData("section_a_test_content", this.fetchedTestContent);

        // Fetch all questions.
        fetchData("section_a_questions", this.fetchedQuestions);

        // Fetch the information on which team is taking which test.
        fetchData("section_a_test_teams", this.fetchedTestTeams);

        // Fetch all users.
        fetchData("users", this.fetchedUsers);
      },

      watch: {
        deleteConfirmation: function() {
          // Delete the user when the confirmation is "delete"
          if (this.deleteConfirmation == "delete") {
            switch (this.deleteItemType) {
              case "question":
                this.deleteTestContent(this.deleteIndex);

                this.fetchedTestContent.splice(this.deleteIndex, 1);
                break;

              case "team":
                this.deleteTestTeam(this.deleteIndex);

                this.fetchedTestTeams.splice(this.deleteIndex, 1);
                break;

              case "test":
                var deletedTest = this.fetchedTests[this.deleteIndex];

                // Delete the test content that was in this test.
                for (var i = 0; i < this.fetchedTestContent.length; i++) {
                  if (this.fetchedTestContent[i].testId == deletedTest.id) {
                    this.deleteTestContent(i);
                  }
                }

                // Delete the test teams that were in this test.
                for (var i = 0; i < this.fetchedTestTeams.length; i++) {
                  if (this.fetchedTestTeams[i].testId == deletedTest.id) {
                    this.deleteTestTeam(i);
                  }
                }

                // Delete the entire test, finally.
                this.deleteTest(this.deleteIndex);

                this.fetchedTests.splice(this.deleteIndex, 1);
            }

            this.deleteConfirmation = "";
            $("div#delete-modal").foundation("close"); // Close the delete modal.
          }
        }
      }
    });
    </script>
  </body>
</html>
