<?php
session_start();
if (!isset($_SESSION['logged']))
{
  header('Location: adminlogin.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Add student</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('adminpanel.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="addstudent.php">
      Add new student<br>
      <label>Name:</label>
      <input id="nameInput" class="normalInput" name="name" oninput="lockButton()"><br>
      <label>ID:</label>
      <input type="number" id="idInput" class="normalInput" name="id" oninput="lockButton()"><br>
      <input id="submitButton" type="submit" value="Add new student">
      <?php
      if(isset($_SESSION['idTaken']))
      {
        echo '<div style="margin-top: 20px; padding: 20px 0 20px 0; border: 1px solid red; border-radius: 5px; background-color: #ffb3b3">ID already taken</div>';
      }
      unset($_SESSION['idTaken']);
      ?>
    </form>
  </div>
  <script type="text/javascript">
  function lockButton()
  {
    var nameValue = document.forms["loginBox"]["nameInput"].value;
    var idValue = document.forms["loginBox"]["idInput"].value;
    if (nameValue == null || nameValue == "" || idValue == null || idValue == "")
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
