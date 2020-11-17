<?php
session_start();
if (!isset($_SESSION['logged']))
{
  header('Location: adminlogin.php');
  exit();
}

require_once "connect.php";

$connect = @new mysqli($host, $userDB, $passwordDB, $database);

if ($connect->connect_errno!=0)
{
  echo "Error: ".$connect->connect_errno;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Edit student</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('adminpanel.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="updatestudent.php">
      Edit student<br>
      <label>Name:</label>
      <?php
      if(isset($_SESSION['idTaken']))
      {
        $toedit = $_SESSION['idTaken'];
      }
      else
      {
        $toedit = $_POST['edit'];
      }
      echo "<input type='hidden' name='idh' value='$toedit'>";
      $sql = "SELECT name FROM students WHERE sid='$toedit'";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($result);
      $name = $row['name'];
      echo "<input id='nameInput' class='normalInput' name='name' value='$name' oninput='lockButton(\"name\", \"id\")'>";
      $sql = "SELECT id FROM students WHERE sid='$toedit'";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($result);
      $id = $row['id'];
      echo "<br><label>ID:</label>";
      echo "<input type='number' id='idInput' class='normalInput' name='id' value='$id' oninput='lockButton(\"name\", \"id\")'><br>";
      ?>
      <input id="submitButton" type="submit" value="Save changes">
      <?php
      if(isset($_SESSION['idTaken']))
      {
        echo '<div style="margin-top: 20px; padding: 20px 0 20px 0; border: 1px solid red; border-radius: 5px; background-color: #ffb3b3">ID already taken</div>';
        unset($_SESSION['idTaken']);
      }
      ?>
    </form>
  </div>
  <script src="lockbutton.js" type="text/javascript">
  </script>
</body>
</html>
