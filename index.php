<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Home</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" href="#">
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
<script type="text/javascript">
function getCookieValue(a) {
  var b = document.cookie.match('(^|;)\\s*' + a + '\\s*=\\s*([^;]+)');
  return b ? b.pop() : '';
}
if (document.cookie.match(/^(.*;)?\s*scanned\s*=\s*[^;]+(.*)?$/))
{
  if (getCookieValue('scanned') != 0)
  {
    document.body.style.backgroundImage = "linear-gradient(to bottom right, #4ddbff 20%, #20ff35 90%)";
    document.body.style.backgroundColor = "#20ff35";
    document.getElementById("please").innerHTML = getCookieValue('scanned').replace("%20", " ");
    setTimeout(function(){document.getElementById("please").innerHTML = "Put your card"}, 2000);
    setTimeout(function(){document.body.style.backgroundImage = "linear-gradient(to bottom right, #70db70 20%, #0066ff 90%)"}, 2000);
  }
  else
  {
    document.body.style.backgroundImage = "linear-gradient(to bottom right, #4ddbff 20%, #ff2020 90%)";
    document.body.style.backgroundColor = "#ff2020";
    document.getElementById("adminbutton").style.borderColor = "#ff2020";
    document.getElementById("please").innerHTML = "Card unrecognized";
    setTimeout(function(){document.getElementById("please").innerHTML = "Put your card"}, 2000);
    setTimeout(function(){document.getElementById("adminbutton").style.borderColor = "#70db70"}, 1800);
    setTimeout(function(){document.body.style.backgroundImage = "linear-gradient(to bottom right, #70db70 20%, #0066ff 90%)"}, 2000);
  }
  setTimeout(function(){document.body.style.backgroundColor = "#c4c4c4"; }, 2000);
  document.cookie = "scanned=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
}
keys = "";
document.onkeypress = function(e) {
  if (keys.length > 9)
  {
    document.cookie = "idQuery=" + keys;
    keys = "";
    window.location.href = "index.php";
  }
  get = window.event?event:e;
  key = get.keyCode?get.keyCode:get.charCode;
  key = String.fromCharCode(key);
  keys+=key;
}
</script>
</body>
</html>
