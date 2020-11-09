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
  if (isset($_POST['name']) && isset($_POST['id']))
  {
    $idh = $_POST['idh'];
    $name = $_POST['name'];
    $id = $_POST['id'];

    $recordCheck = mysqli_query($connect, "SELECT COUNT(1) FROM students WHERE id=".$id);
    $row= mysqli_fetch_row($recordCheck);
    if($row[0] == 0)
    {
      $sql = "UPDATE students SET id='$id', name='$name' WHERE sid='$idh'";
      $result = mysqli_query($connect, $sql);
      header('Location: adminpanel.php');
      exit();
    }
    else
    {
      $sql = "SELECT id FROM students WHERE sid='$idh'";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($result);
      $oldid = $row['id'];
      if ($oldid == $id)
      {
        $sql = "UPDATE students SET id='$id', name='$name' WHERE sid='$idh'";
        $result = mysqli_query($connect, $sql);
        header('Location: adminpanel.php');
        exit();
      }
      else {
        $_SESSION['idTaken'] = $idh;
        header('Location: editstudent.php');
        exit();
      }
    }
  }
}

header('Location: adminpanel.php');
exit();
?>
