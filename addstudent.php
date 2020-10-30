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
  if (isset($_POST['name']) && isset($_POST['id']))
  {
    $name = $_POST['name'];
    $id = $_POST['id'];

    $recordCheck = mysqli_query($connect, "SELECT COUNT(1) FROM students WHERE id=".$id);
    $row= mysqli_fetch_row($recordCheck);
    if($row[0] >= 1)
    {
      $_SESSION['idTaken'] = true;
      header('Location: addingstudent.php');
      exit();
    }
    else {
      $sql = "INSERT INTO students (id, name) VALUES ('$id', '$name')";
      $result = mysqli_query($connect, $sql);
      header('Location: adminpanel.php');
      exit();
    }
  }
}
header('Location: adminpanel.php');
exit();
?>
