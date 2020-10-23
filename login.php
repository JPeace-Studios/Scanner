<?php
session_start();
require_once "connect.php";

$connect = @new mysqli($host, $userDB, $passwordDB, $database);

if ($connect->connect_errno!=0)
{
  echo "Error: ".$connect->connect_errno;
}
else {
  if (isset($_POST['login']) && isset($_POST['password']))
  {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $login = mysqli_real_escape_string($connect, $login);
    $password = htmlentities($password, ENT_QUOTES, "UTF-8");
    $password = mysqli_real_escape_string($connect, $password);

    $sql = "SELECT * FROM account WHERE BINARY login='$login' AND BINARY password='$password' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    if(mysqli_num_rows($result) == 1)
    {
      unset($_SESSION['loginError']);
      $_SESSION['logged'] = true;
      header('Location: adminpanel.php');
    }
    else {
      $_SESSION['loginError'] = true;
      header('Location: adminlogin.php');
    }
  }
}
?>
