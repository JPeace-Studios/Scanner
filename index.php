<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Home</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
<?php
require_once "connect.php";
require_once "activelesson.php";
$connect = @new mysqli($host, $userDB, $passwordDB, $database);
if ($connect->connect_errno!=0)
{
  echo "Error: ".$connect->connect_errno;
}
?>
</head>
<body>
  <?php
  if (isset($_COOKIE["idQuery"]))
  {
      $nowStamp = time();
      $idQuery = $_COOKIE["idQuery"];
      $sql = "SELECT * FROM students WHERE BINARY id LIKE $idQuery";
      if ($result = @$connect-> query($sql))
      {
        while($row = $result-> fetch_assoc())
        {
          $sid = $row['sid'];
          $name = $row['name'];
          setcookie('scanned', $name);
        }
        $highestCheck = activelesson();
        if (isset($highestCheck) && isset($sid))
        {
          $sql = "SELECT status FROM lesson".$highestCheck." WHERE sid =".$sid;
          if ($result = @$connect-> query($sql))
          {
            $row = mysqli_fetch_row($result);
            if ($row[0] == 0)
            {
              $hc180 = $highestCheck + 180;
              $hc900 = $highestCheck + 900;
              if ($nowStamp <= $hc180)
              {
                $sql = "UPDATE lesson".$highestCheck." SET status = 1 WHERE sid =".$sid;
                $result = @$connect-> query($sql);
              }
              elseif ($nowStamp > $hc180 && $nowStamp <= $hc900)
              {
                $sql = "UPDATE lesson".$highestCheck." SET status = 2 WHERE sid =".$sid;
                $result = @$connect-> query($sql);
              }
            }
          }
        }
      }
      if (!isset($name))
      {
        setcookie('scanned', 0);
      }
      setcookie('idQuery', null, -1);
  }
  ?>
<div id="buttonWrapper">
<button id="adminbutton" type="button" onclick="location.replace('adminlogin.php')">Admin panel</button>
</div>
<div id ="please">Put your card</div>
<img src="card.png" id="cardlogo">
<script src="getcookievalue.js" type="text/javascript">
</script>
<script src="homescript.js" type="text/javascript">
</script>
</body>
</html>
