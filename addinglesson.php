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
<title>Scanner - Add lesson</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('adminpanel.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="addLesson.php">
      Add new lesson<br>
      <label>Set date:</label>
      <input type="date" id="ldate" class="normalInput" name="ldate" oninput="lockButton()"><br>
      <label>Set time:</label>
      <input type="time" id="ltime" class="normalInput" name="ltime" oninput="lockButton()"><br>
      <input type="submit" id="submitButton" value="Add new lesson">
      <?php
      if(isset($_SESSION['lessonTaken']))
      {
        echo '<div style="margin-top: 20px; padding: 20px 0 20px 0; border: 1px solid red; border-radius: 5px; background-color: #ffb3b3">There is already lesson at this time</div>';
      }
      unset($_SESSION['lessonTaken']);
      ?>
    </form>
  </div>
  <script type="text/javascript">
  function lockButton()
  {
    var dateValue = document.forms["loginBox"]["ldate"].value;
    var timeValue = document.forms["loginBox"]["ltime"].value;
    if (dateValue == null || dateValue == "" || timeValue == null || timeValue == "")
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
