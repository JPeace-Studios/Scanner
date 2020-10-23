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
else {
  if (isset($_POST['ldate']) && isset($_POST['ltime']))
  {
    $date = $_POST['ldate'];
    $time = $_POST['ltime'];

    $sql = "SHOW TABLES FROM ".$database;
    if ($result = @$connect-> query($sql))
    {
      $lessons = array();
      while($row = $result-> fetch_assoc())
      {
        if (strpos($row['Tables_in_'.$database], "lesson") !== false)
        {
          array_push($lessons, $row['Tables_in_'.$database]);
        }
      }
      $lessonNumber = count($lessons) + 1;
      $sql = "select count(1) FROM students";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_array($result);
      $numberOfStudents = $row['count(1)'];
      if ($numberOfStudents > 0)
      {
        while (True) {
          $tableCheck = mysqli_query($connect, "SELECT 1 FROM lesson".$lessonNumber." LIMIT 1");
          if ($tableCheck !== false)
          {
            $lessonNumber += 1;
          }
          else
          {
            break;
          }
        }
        $sql = "CREATE TABLE lesson".$lessonNumber." (sid INT NOT NULL AUTO_INCREMENT,
        presence BIT,
        PRIMARY KEY (sid)
        );";
        $result = mysqli_query($connect, $sql);
        for ($x = 1; $x <= $numberOfStudents; $x++)
        {
          $sql = "INSERT INTO lesson".$lessonNumber." (sid, presence) VALUES (".$x.", 0)";
          $result = mysqli_query($connect, $sql);
        }
      }
    }
  }
  header('Location: adminpanel.php');
  echo $date . " " . $time;
}
?>
