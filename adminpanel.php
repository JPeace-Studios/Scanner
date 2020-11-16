<?php
session_start();
if (!isset($_SESSION['logged']))
{
  header('Location: adminlogin.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner - Admin panel</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
</head>
<body>
  <div id="buttonWrapper">
  <button id="adminbutton" type="button" onclick="location.replace('logout.php')">Log Out</button>
  </div>
  <div id="loginWrapper">
    Admin Panel
    <button id="panelButton" onclick="location.replace('addingstudent.php')">Add new student</button>
    <button id="panelButton" onclick="location.replace('addinglesson.php')">Add new lesson</button>
    <?php
    require_once "connect.php";
    require_once "daily.php";
    require_once "monthly.php";
    require_once "semester.php";

    $connect = @new mysqli($host, $userDB, $passwordDB, $database);

    if ($connect->connect_errno!=0)
    {
      echo "Error: ".$connect->connect_errno;
    }
    else
    {
      $nowStamp = time();
      $lessonTimeAfter = $nowStamp + 2700;
      $sql = "SELECT * FROM students";
      if ($result = @$connect-> query($sql))
      {
        echo "<button id='panelButton' onclick='buttonclick(-1);'>Show/Hide students table</button><div id='-1' class='hideOff' style='margin-bottom: 5px'><table class='nicelook'>";
        echo "<tr><td>No.</td><td>ID</td><td>Name</td><td>Daily attendance</td><td>Monthly attendance</td><td>Semester attendance</td></tr>";

        while($row = $result-> fetch_assoc())
        {
          $aid = $row['sid'];
          echo "<tr><td>".$row['sid']."</td><td>".$row['id']."</td><td>".$row['name']."</td><td>".daily($aid)."</td><td>".monthly($aid)."</td><td>".semester($aid)."</td><td>";
          echo "<form action='editstudent.php' method='post'>";
          echo "<input type='hidden' name='edit' value='$aid'>";
          echo "<input type='submit' class='actionButton editButton' value=''></form></td><td>";
          echo "<form action='removestudent.php' method='post'>";
          echo "<input type='hidden' name='delete' value='$aid'>";
          echo "<input type='submit' class='actionButton removeButton' value=''></form></td></tr>";
        }
        echo "</table></div>";
      }

      $sql = "SHOW TABLES FROM ".$database;
      $result = @$connect-> query($sql);
      $lessons = array();
      $numberOfLessons = 0;
      while ($row = mysqli_fetch_row($result))
      {
        if (strspn($row[0],"lesson") == 6)
        {
          array_push($lessons, $row[0]);
          $numberOfLessons++;
        }
      }
      for ($i = 0; $i < $numberOfLessons; $i++)
      {
        $sql = "SELECT * FROM ".$lessons[$i];
        if ($result = @$connect-> query($sql))
        {
          echo "<button id='panelButton' onclick='buttonclick($i);'>Lesson on ".date('d/m/Y H:i', substr($lessons[$i], 6))."</button><div id='$i' class='hideOn'>";
          echo "<table class='nicelook2' style='text-align: center; padding: 30px'>";
          echo "<tr><th colspan='3'>".date('d/m/Y H:i', substr($lessons[$i], 6))."</th></tr>";
          echo "<tr><td colspan='3' class='lessonButtonCell'>";
          echo "<form action='editlesson.php' class='editButtonLesson' method='post'>";
          echo "<input type='hidden' name='edit' value='$lessons[$i]'>";
          echo "<input type='submit' class='actionButton editButton' value=''></form>";
          echo "<form action='removelesson.php' class='removeButtonLesson' method='post'>";
          echo "<input type='hidden' name='delete' value='$lessons[$i]'>";
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
            if (substr($lessons[$i],6) > $lessonTimeAfter)
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
    }
    ?>
    <script type="text/javascript">
      function buttonclick(a)
      {
        var shade = document.getElementById(a);
        if (shade.className == "hideOn")
        {
          shade.className = "hideOff";
        } else {
          shade.className = "hideOn";
        }
      }
    </script>
  </div>
</body>
</html>
