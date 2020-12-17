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
<script src="showhide.js" type="text/javascript"></script>
</head>
<body>
  <div id="buttonWrapper">
  <a href="index.php" id="headerLogo">Scanner</a>
  <a href="logout.php" id ="logOutbutton" class="topButton"></a>
  </div>
  <div>
    <div id="sidePanel">
    <div class="sideButtons">
    <a id="studentsBtn" onclick="changeContent('studentsTable', 1);">
    <div id="studentsPic" class="sidePic"></div>
    Students
    </a>
    <a id="studentsAddBtn" href="addingstudent.php">
    <div id="studentsAddBtnPic"></div>
    </a>
    </div>
    <div class="btnBorder"></div>
    <a class="sideButtons lessonsBtn" href="addinglesson.php">
    <div id="lessonAddPic" class="sidePic"></div>
    Add new lesson
    </a>
    <?php
    $nowStamp = time();
    $beginOfToday = strtotime("today", $nowStamp);
    $beginOfTomorrow = $beginOfToday + 86400;
    $endOfTomorrow = $beginOfTomorrow + 86399;
    $sql = "SHOW TABLES FROM ".$database;
    $result = @$connect-> query($sql);
    $lessons = array();
    while ($row = mysqli_fetch_row($result))
    {
      if (strspn($row[0],"lesson") == 6)
      {
        array_push($lessons, substr($row[0], 6));
      }
    }
    for ($i = 0; $i < count($lessons); $i++)
    {
      if ($lessons[$i] < $beginOfToday)
      {
        if (!isset($finishedLessons))
        {
          $finishedLessons = array();
        }
        array_push($finishedLessons, $lessons[$i]);
      }
      elseif ($lessons[$i] >= $beginOfToday && $lessons[$i] < $beginOfTomorrow)
      {
        if (!isset($todayLessons))
        {
          $todayLessons = array();
        }
        array_push($todayLessons, $lessons[$i]);
      }
      elseif ($lessons[$i] >= $beginOfTomorrow && $lessons[$i] < $endOfTomorrow)
      {
        if (!isset($tomorrowLessons))
        {
          $tomorrowLessons = array();
        }
        array_push($tomorrowLessons, $lessons[$i]);
      }
      elseif ($lessons[$i] > $endOfTomorrow)
      {
        if (!isset($furtherLessons))
        {
          $furtherLessons = array();
        }
        array_push($furtherLessons, $lessons[$i]);
      }
    }
    if (isset($todayLessons))
    {
      echo '<div class="lessongroup">Today</div>';
      for ($j=0; $j < count($todayLessons); $j++)
      {
        echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$todayLessons[$j].'\', 1)">'.date("H:i",$todayLessons[$j]).'</a>';
      }
    }
    if (isset($tomorrowLessons))
    {
      echo '<div class="lessongroup">Tomorrow</div>';
      for ($j=0; $j < count($tomorrowLessons); $j++)
      {
        echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$tomorrowLessons[$j].'\', 1)">'.date("H:i",$tomorrowLessons[$j]).'</a>';
      }
    }
    if (isset($finishedLessons))
    {
      echo '<div class="lessongroup">Finished</div>';
      $newFinishedLessons = array();
      for ($j= count($finishedLessons) -1; $j >= 0; $j--)
      {
        if ($finishedLessons[$j] < strtotime("today",end($newFinishedLessons)) || $finishedLessons[$j] > strtotime("today",(end($newFinishedLessons) + 86400)) || empty($newFinishedLessons))
        {
          echo '<div class="lessondate">'.date("j F", $finishedLessons[$j]);
          if (date("Y", $nowStamp) != date("Y",$finishedLessons[$j]))
          {
            echo " ".date("Y", $finishedLessons[$j]);
          }
          echo '</div>';
        }
        array_push($newFinishedLessons, $finishedLessons[$j]);
        echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$finishedLessons[$j].'\', 1)">'.date("H:i",$finishedLessons[$j]).'</a>';
      }
    }
    if (isset($furtherLessons))
    {
      echo '<div class="lessongroup">Further</div>';
      $newFurtherLessons = array();
      for ($j=0; $j < count($furtherLessons); $j++)
      {
        if ($furtherLessons[$j] < strtotime("today",end($newFurtherLessons)) || $furtherLessons[$j] > strtotime("today",(end($newFurtherLessons) + 86400)) || empty($newFurtherLessons))
        {
          echo '<div class="lessondate">'.date("j F", $furtherLessons[$j]);
          if (date("Y", $nowStamp) != date("Y",$furtherLessons[$j]))
          {
            echo " ".date("Y", $furtherLessons[$j]);
          }
          echo '</div>';
        }
        array_push($newFurtherLessons, $furtherLessons[$j]);
        echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$furtherLessons[$j].'\', 1)">'.date("H:i",$furtherLessons[$j]).'</a>';
      }
    }
    ?>
  </div>
  <div id="contentBox">
    <form id="loginBox" method="post" action="updatelesson.php">
      Change lesson time<br>
      <?php
      if(isset($_SESSION['lessonTaken']))
      {
        echo '<div class="errorMessage"><div class="errorIcon"></div>There is already lesson at this time</div>';
      }
      unset($_SESSION['lessonTaken']);
      echo "<label class='labelMargin'>Set date: </label>";
      echo "<input type='date' id='ldate' class='normalInput' name='ldate' oninput='lockButton(\"ldate\", \"ltime\")' value='".date('Y-m-d', substr($toedit, 6))."'><br>";
      echo "<label class='labelMargin'>Set time: </label>";
      echo "<input type='time' id='ltime' class='normalInput' name='ltime' oninput='lockButton(\"ldate\", \"ltime\")' value='".date('H:i', substr($toedit, 6))."'><br>";
      echo "<input type='hidden' name='lessonID' value='$toedit'>";
      echo "<table>";
      echo "<tr><td><input id='submitButton' type='submit' disabled value='Save changes'></td>";
      echo "<td><input id='submitButton' type='button' onclick='window.history.back();' value='Cancel'></td></tr>";
      echo "</table>";
      ?>
    </form>
    <form id="statusBox" method="post" action="changestatus.php">
      Change student's attendance
      <?php
      $sql = "SELECT * FROM ".$toedit;
      if ($result = @$connect-> query($sql))
      {
        echo "<table class='tablestyle tablestyle3'><tr><td>No.</td><td>Status</td></tr>";
        while ($row = mysqli_fetch_assoc($result))
        {
          echo "<tr><td>".$row['sid']."</td><td>";
          echo "<select id='".$row['sid']."' class='statusSelect' onchange='changestatus(".$row['sid'].")'>";
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
  </div>
  <script src="lockbutton.js" type="text/javascript">
  </script>
  <script src="changestatus.js" type="text/javascript">
  </script>
</body>
</html>
