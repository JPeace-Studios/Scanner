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
    $lessonStamp = strtotime($date.' '.$time);

    $sql = "SHOW TABLES FROM ".$database;
    if ($result = @$connect-> query($sql))
    {
      $sql = "select count(1) FROM students";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_array($result);
      $numberOfStudents = $row['count(1)'];
      if ($numberOfStudents > 0)
      {
        while (True) {
          $tableCheck = mysqli_query($connect, "SELECT 1 FROM lesson".$lessonStamp." LIMIT 1");
          if ($tableCheck !== false)
          {
            $_SESSION['lessonTaken'] = true;
            header('Location: addinglesson.php');
            exit();
          }
          else
          {
            break;
          }
        }

        $sql = "CREATE TABLE lesson".$lessonStamp." (sid INT NOT NULL AUTO_INCREMENT,
        status INT,
        PRIMARY KEY (sid)
        );";
        $result = mysqli_query($connect, $sql);
        for ($x = 1; $x <= $numberOfStudents; $x++)
        {
          $sql = "INSERT INTO lesson".$lessonStamp." (sid, status) VALUES (".$x.", 0)";
          $result = mysqli_query($connect, $sql);
        }
      }
      }
    }
  }
  header('Location: adminpanel.php');
  exit();
?>
