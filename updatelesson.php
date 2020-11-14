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
else
{
  if (isset($_POST['ldate']) && isset($_POST['ltime']) && isset($_POST['lessonID']))
  {
    $date = $_POST['ldate'];
    $time = $_POST['ltime'];
    $lessonID = $_POST['lessonID'];
    $lessonStamp = strtotime($date.' '.$time);

    $tableCheck = mysqli_query($connect, "SELECT 1 FROM lesson".$lessonStamp." LIMIT 1");
    if ($tableCheck !== false)
    {
      $_SESSION['lessonTaken'] = $lessonID;
      header('Location: editlesson.php');
      exit();
    }

    $sql = "RENAME TABLE `$lessonID` TO `lesson$lessonStamp`";
    $result = @$connect-> query($sql);

  }
}
  header('Location: adminpanel.php');
  exit();
?>
