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
<link rel="icon" href="#">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('adminpanel.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    Add new lesson<br>
    <form method="post" action="addLesson.php">
      <label>Set date:</label>
      <input type="date" name="ldate"><br>
      <label>Set time:</label>
      <input type="time" name="ltime"><br>
      <input type="submit" value="Add new lesson">
    </form>
  </div>

<body>
</html>
