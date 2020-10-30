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
<title>Scanner - Admin panel</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" href="#">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('logout.php')">Log Out</button>
  </div>
  <div id="loginWrapper">
    Admin Panel
    <button onclick="location.replace('addingstudent.php')">Add new student</button>
    <button onclick="location.replace('addinglesson.php')">Add new lesson</button>
    <?php
    require_once "connect.php";

    $connect = @new mysqli($host, $userDB, $passwordDB, $database);

    if ($connect->connect_errno!=0)
    {
      echo "Error: ".$connect->connect_errno;
    }
    else
    {
      $sql = "SELECT * FROM students";
      if ($result = @$connect-> query($sql))
      {
        echo "<style> td {padding: 10px; } </style>";
        echo '<table style="text-align: center;">';
        echo "<tr><td>No.</td><td>ID</td><td>Name</td></tr>";
        while($row = $result-> fetch_assoc())
        {
          echo "<tr><td>".$row['sid']."</td><td>".$row['id']."</td><td>".$row['name']."</td><td>";
          $aid = $row['sid'];
          echo "<form action='editstudent.php' method='post'>";
          echo "<input type='hidden' name='edit' value='$aid'>";
          echo "<input type='submit' class='actionStudent editStudent' value=''></form></td><td>";
          echo "<form action='removestudent.php' method='post'>";
          echo "<input type='hidden' name='delete' value='$aid'>";
          echo "<input type='submit' class='actionStudent removeStudent' value=''></form></td></tr>";
        }
      }
      echo "</table>";
    }
    ?>
  </div>
</body>
</html>
