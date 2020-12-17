<?php
session_start();
if (!isset($_SESSION['logged']))
{
  header('Location: adminlogin.php');
  exit();
}

require_once "connect.php";
require_once "daily.php";
require_once "monthly.php";
require_once "semester.php";

$connect = @new mysqli($host, $userDB, $passwordDB, $database);

if ($connect->connect_errno!=0)
{
  echo "Error: ".$connect->connect_errno;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Admin panel</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
<script src="showhide.js" type="text/javascript"></script>
<script src="adminpanelhash.js" type="text/javascript"></script>
</head>
<body onload="hashRedirect();">
  <div id="buttonWrapper">
  <a href="index.php" id="headerLogo">Scanner</a>
  <a href="logout.php" id ="logOutbutton" class="topButton"></a>
  </div>
  <div>
  <div id="sidePanel">
  <div class="sideButtons">
  <a id="studentsBtn" onclick="changeContent('studentsTable');">
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
      echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$todayLessons[$j].'\')">'.date("H:i",$todayLessons[$j]).'</a>';
    }
  }
  if (isset($tomorrowLessons))
  {
    echo '<div class="lessongroup">Tomorrow</div>';
    for ($j=0; $j < count($tomorrowLessons); $j++)
    {
      echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$tomorrowLessons[$j].'\')">'.date("H:i",$tomorrowLessons[$j]).'</a>';
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
      echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$finishedLessons[$j].'\')">'.date("H:i",$finishedLessons[$j]).'</a>';
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
      echo '<a class="sideButtons lessonsBtn" onclick="changeContent(\'table'.$furtherLessons[$j].'\')">'.date("H:i",$furtherLessons[$j]).'</a>';
    }
  }
  ?>
  </div>
  <div id="contentWrapper">
    <?php
      $lessonTimeAfter = $nowStamp + 2700;
      $sql = "SELECT COUNT(sid) FROM students";
      if ($result = @$connect-> query($sql))
      {
        $row = $result-> fetch_row();
        if ($row[0] == "0")
        {
          echo "<div id='nostudents'>There is no students</div>";
        }
        else
        {
          $sql = "SELECT * FROM students";
          if ($result = @$connect-> query($sql))
          {
            echo "<div id='studentsTable' class='hideOff'><table id='studentsTableReal' class='tablestyle tablestyle1' cellspacing='0'>";
            echo "<thead><tr class='tableheader'><th>No.</th><th>ID</th><th>Name</th><th>Daily attendance</th><th>Monthly attendance</th><th>Semester attendance</th><th colspan='2'>Actions</th></tr></thead><tbody>";

            while($row = $result-> fetch_assoc())
            {
              $aid = $row['sid'];
              echo "<tr><td>".$row['sid']."</td><td>".$row['id']."</td><td>".$row['name']."</td><td>".daily($aid)."</td><td>".monthly($aid)."</td><td>".semester($aid)."</td><td>";
              echo "<form class='studentsActionForms' action='editstudent.php' method='post'>";
              echo "<input type='hidden' name='edit' value='$aid'>";
              echo "<input type='submit' class='actionButton editButton' value=''></form></td><td>";
              echo "<form class='studentsActionForms' action='removestudent.php' method='post'>";
              echo "<input type='hidden' name='delete' value='$aid'>";
              echo "<input type='submit' class='actionButton removeButton' value=''></form></td></tr>";
            }
            echo "</tbody></table></div>";
          }
        }
      }

      for ($i = 0; $i < count($lessons); $i++)
      {
        $sql = "SELECT * FROM lesson".$lessons[$i];
        if ($result = @$connect-> query($sql))
        {
          echo "<div id='table".$lessons[$i]."' class='hideOn' style='width: 100%'>";
          echo "<table class='tablestyle tablestyle2' cellspacing='0' style='text-align: center; padding: 30px'>";
          echo "<tr><th colspan='3'>".date('d/m/Y H:i', $lessons[$i])."</th></tr>";
          echo "<tr><td colspan='3' class='lessonButtonCell'>";
          echo "<form action='editlesson.php' class='editButtonLesson' method='post'>";
          echo "<input type='hidden' name='edit' value='lesson".$lessons[$i]."'>";
          echo "<input type='submit' class='actionButton editButton' value=''></form>";
          echo "<form action='removelesson.php' class='removeButtonLesson' method='post'>";
          echo "<input type='hidden' name='delete' value='lesson".$lessons[$i]."'>";
          echo "<input type='submit' class='actionButton removeButton' value=''></form></td></tr>";
          echo "<tr><td>No.</td><td>Name</td><td>Status</td></tr>";
          while ($row = mysqli_fetch_assoc($result))
          {
            echo "<tr><td>".$row['sid']."</td><td>";
            $sql = "SELECT name FROM students WHERE sid=".$row['sid'];
            if ($resultName = $connect-> query($sql))
            {
              $rowName = mysqli_fetch_assoc($resultName);
              if ($rowName == null)
              {
                echo "deleted student</td><td>";
              }
              else {
                echo $rowName['name']."</td><td>";
              }
            }
            if ($lessons[$i] > $lessonTimeAfter)
            {
              echo "N/A</td></tr>";
            }
            else
            {
              if ($row['status'] == 0)
              {
                  echo "absent</td></tr>";
              }
              elseif ($row['status'] == 1)
              {
                echo "present</td></tr>";
              }
              elseif ($row['status'] == 2)
              {
                echo "late</td></tr>";
              }
            }
          }
          echo "</table></div>";
        }
      }
    ?>
  </div>
</div>
</body>
</html>
