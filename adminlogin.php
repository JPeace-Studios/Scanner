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
  <a href="index.php" id="headerLogo">Scanner</a>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="login.php">
      Adminstrator panel
      <?php
      if(isset($_SESSION['loginError']))
      {
        echo '<div class="errorMessage"><div class="errorIcon"></div>Incorrect login or password</div>';
        ?>
        <script src="logingradient.js" type="text/javascript">
        </script>
        <?php
      }
      unset($_SESSION['loginError']);
      ?>
      <div class="inputSection">
      <input type="text" id="login" name="login" oninput="lockButton('login', 'password')" required>
      <label for="login" class="labelName">
        <span class="labelText">Login</span>
      </label>
      </div>
      <div class="inputSection">
      <input type="password" id="password" name="password" oninput="lockButton('login', 'password')" required>
      <label for="password" class="labelName">
        <span class="labelText">Password</span>
      </label>
      </div>
      <div>
      <input type="submit" id="submitButton" disabled value="Log In">
      <input type="button" id="submitButton" value="Cancel" onclick="window.history.back();">
      </div>

    </form>
  </div>
  <script src="lockbutton.js" type="text/javascript">
  </script>
</body>
</html>
