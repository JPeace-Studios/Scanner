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
  if (isset($_SESSION['lessonTaken']))
  {
    $toedit = $_SESSION['lessonTaken'];
  }
  else
  {
    if (isset($_POST['edit']))
    {
      $toedit = $_POST['edit'];
    }
    else
    {
      if (isset($_COOKIE["ldate"]) && isset($_COOKIE["ltime"]))
      {
        $ldatet = $_COOKIE["ldate"];
        $ltimet = $_COOKIE["ltime"];
        $toedit = "lesson".strtotime($ldatet." ".$ltimet);
        setcookie('ldate', null, -1);
        setcookie('ltime', null, -1);
        $changestatus = $_COOKIE["changestatus"];
        $sid = strtok($changestatus, ',');
        $status = substr($changestatus, -1);

        $sql = "UPDATE ".$toedit." SET status=".$status." WHERE sid=".$sid;
        $result = @$connect-> query($sql);
      }
      else
      {
        header('Location: adminpanel.php');
        exit();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Edit lesson</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('adminpanel.php')">Go back</button>
  </div>
  <div id="loginWrapper">
    <form id="loginBox" method="post" action="updatelesson.php">
      Change lesson time<br>
      <?php
      echo "<label>Set date: </label>";
      echo "<input type='date' id='ldate' class='normalInput' name='ldate' oninput='lockButton()' value='".date('Y-m-d', substr($toedit, 6))."'><br>";
      echo "<label>Set time: </label>";
      echo "<input type='time' id='ltime' class='normalInput' name='ltime' oninput='lockButton()' value='".date('H:i', substr($toedit, 6))."'><br>";
      echo "<input type='hidden' name='lessonID' value='$toedit'>";
      echo "<input type='submit' id='submitButton' value='Save changes'>";
      
      if(isset($_SESSION['lessonTaken']))
      {
        echo '<div style="margin-top: 20px; padding: 20px 0 20px 0; border: 1px solid red; border-radius: 5px; background-color: #ffb3b3">There is already lesson at this time</div>';
      }
      unset($_SESSION['lessonTaken']);
      ?>
    </form>
    <form id="statusBox" method="post" action="changestatus.php">
      Change student's attendance
      <?php
      $sql = "SELECT * FROM ".$toedit;
      if ($result = @$connect-> query($sql))
      {
        echo "<table class='nicelook3'><tr><td>No.</td><td>Status</td></tr>";
        while ($row = mysqli_fetch_assoc($result))
        {
          echo "<tr><td>".$row['sid']."</td><td>";
          echo "<select id='".$row['sid']."' onchange='changestatus(".$row['sid'].")'>";
          if ($row['status'] == 0)
          {
            echo "<option value='absent' selected>absent</option>";
            echo "<option vlaue='present'>present</option>";
            echo "<option vlaue='late'>late</option>";
          }
          elseif ($row['status'] == 1)
          {
            echo "<option value='absent'>absent</option>";
            echo "<option vlaue='present' selected>present</option>";
            echo "<option vlaue='late'>late</option>";
          }
          elseif ($row['status'] == 2)
          {
            echo "<option value='absent' selected>absent</option>";
            echo "<option vlaue='present'>present</option>";
            echo "<option vlaue='late' selected>late</option>";
          }
          echo "</select></td></tr>";
        }
        echo "</table>";
      }
      ?>
    </form>
  </div>
  <script type="text/javascript">
  function lockButton()
  {
    var dateValue = document.forms["loginBox"]["ldate"].value;
    var timeValue = document.forms["loginBox"]["ltime"].value;
    if (dateValue == null || dateValue == "" || timeValue == null || timeValue == "")
    {
      document.getElementById("submitButton").disabled = true;
      document.getElementById("submitButton").style.cursor = 'not-allowed';
    }
    else
    {
      document.getElementById("submitButton").disabled = false;
      document.getElementById("submitButton").style.cursor = 'pointer';
    }
  }
  function changestatus(sid)
  {
    var ldate = document.getElementById("ldate").value;
    var ltime = document.getElementById("ltime").value;
    var changed = document.getElementById(sid).value;
    //document.getElementById("loginBox").innerHTML = "You selected: " + changed;
    if (changed == "absent")
    {
      changed = 0;
    }
    else if (changed == "present")
    {
      changed = 1;
    }
    else if (changed == "late")
    {
      changed = 2;
    }
    document.cookie = "ldate=" + ldate;
    document.cookie = "ltime=" + ltime;
    document.cookie = "changestatus=" +  sid + "," + changed;
    window.location.href = "editlesson.php";
  }
  lockButton();
  </script>
</body>
</html>
