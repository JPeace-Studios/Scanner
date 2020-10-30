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
    $idh = $_POST['delete'];
    $sql = "DELETE FROM students WHERE sid='$idh'";
    if ($result = @$connect-> query($sql))
    {
      header('Location: adminpanel.php');
      exit();
    }
    else
    {
      echo "Error occur";
    }
}
?>
