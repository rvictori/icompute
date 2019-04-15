<?php
// Source: https://www.johnmorrisonline.com/build-php-login-form-using-sessions/
session_start();

require '_resources/php/database.php';

$sql = "SELECT *
        FROM users";

if ($result = $mysqli->query($sql)) {
  $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (!empty($_POST)) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $valid_user = array();

      for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]['username'] == $_POST['username'] && $array[$i]['password'] == $_POST['password']) {
          $valid_user = $array[$i];
        }
      }

      if (!empty($valid_user)) {
        $_SESSION['id'] = $valid_user['id'];
        $_SESSION['name'] = $valid_user['name'];
        $_SESSION['school'] = $valid_user['school'];
        $_SESSION['is_competitor'] = $valid_user['isCompetitor'];
        $_SESSION['is_grader'] = $valid_user['isGrader'];
        $_SESSION['is_supervisor'] = $valid_user['isSupervisor'];
      } else {
        $invalid = true; // This is for the invalid message.
      }
    }
  }
}

// Redirection.
if (isset($_SESSION['id'])) {
  if ($_SESSION['is_supervisor'] == "true") {
    header("Location: supervisor.php");
  } else if ($_SESSION['is_grader'] == "true") {
    echo "Grader here...";
  } else if ($_SESSION['is_competitor'] == "true") {
    header("Location: section-a.php");
  }
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>iCompute</title>

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
          <div class="callout">
            <p>Log in with the account provided by the supervisor.</p>

            <form action="index.php" method="post">
              <label>Username
                <input type="text" name="username" placeholder="Username" v-model="username" required />
              </label>

              <label>Password
                <input type="password" name="password" placeholder="Password" v-model="password" required />
              </label>

              <p><button class="button expanded" v-on:click="logIn">Log In</button></p>
            </form>

            <?php if (isset($_POST['username'])): ?>
            <div class="callout alert">
              <p>Please enter your correct username and password.</p>
            </div>
            <?php endif; ?>
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
        headingTwo: "Log In",
        users: [],

        username: "",
        password: "",
      },

      methods: {
        logIn: function() {
          var valid = false;

          for (var i = 0; i < this.users.length; i++) {
            if (this.users[i].username == this.username && this.users[i].password == this.password) {
              valid = true;
            }
          }

          console.log(valid);
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData('_resources/txt/users.txt', this.users);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
