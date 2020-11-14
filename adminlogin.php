<?php
session_start();
if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
{
  header('Location: adminpanel.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Log in to admin panel</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('index.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="login.php">
      Log in to adminstrator panel<br>
      <label for="login">Login:</label><br>
      <input type="text" id="login" class="normalInput" name="login" oninput="lockButton()"><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" class="normalInput" name="password" oninput="lockButton()"><br>
      <input type="submit" id="submitButton" value="Log In">
      <?php
      if(isset($_SESSION['loginError']))
      {
        echo '<div style="margin-top: 20px; padding: 20px 0 20px 0; border: 1px solid red; border-radius: 5px; background-color: #ffb3b3">Incorrect login or password</div>';
        ?>
        <script type="text/javascript">
          document.body.style.backgroundImage = "linear-gradient(to bottom right, #4ddbff 20%, #ff2020 90%)";
          document.getElementById("adminbutton").style.borderColor = "#ff2020"
        </script>
        <?php
      }
      unset($_SESSION['loginError']);
      ?>
    </form>
  </div>
  <script type="text/javascript">
  function lockButton()
  {
    var loginValue = document.forms["loginBox"]["login"].value;
    var passwordValue = document.forms["loginBox"]["password"].value;
    if (loginValue == null || loginValue == "" || passwordValue == null || passwordValue == "")
    {
      document.getElementById("submitButton").disabled = true;
      document.getElementById("submitButton").style.cursor = 'not-allowed';
    }
    else
    {
      document.getElementById("submitButton").disabled = false;
      document.getElementById("submitButton").style.cursor = 'pointer';
    }
  }
  lockButton();
  </script>
</body>
</html>
