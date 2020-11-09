<?php

function daily($sid)
{
  require "connect.php";

  if (!isset($connect))
  {
      $connect = @new mysqli($host, $userDB, $passwordDB, $database);
  }
  if ($connect->connect_errno!=0)
  {
    echo "Error: ".$connect->connect_errno;
  }
  else
  {
    $nowStamp = time();
    $lessonTimeAfter = $nowStamp + 2700;
    $hoursToSubtract = date('H') * 3600;
    $minutesToSubtract = date('i') * 60;
    $secoundsToSubtract = date('s');
    $allToSubtract = $hoursToSubtract + $minutesToSubtract + $secoundsToSubtract;
    $dayStart = $nowStamp - $allToSubtract;
    $dayEnd = $dayStart + 86399;

    $sql = "SHOW TABLES FROM ".$database;
    $result = @$connect-> query($sql);
    $lessons = array();
    $numberOfLessons = 0;
    while ($row = mysqli_fetch_row($result))
    {
      if (strspn($row[0],"lesson") == 6)
      {
        $tableCheck = substr($row[0],6);
        if ($lessonTimeAfter > $tableCheck)
        {
          array_push($lessons, $row[0]);
          $numberOfLessons++;
        }
      }
    }
    $allDailyLessons = 0;
    $allDailyAttendance = 0;
    for ($i=0; $i < $numberOfLessons; $i++) {
      if (substr($lessons[$i],6) > $dayStart and substr($lessons[$i],6) < $dayEnd)
      {
        $allDailyLessons++;
        $sql = "SELECT status FROM ".$lessons[$i]." WHERE sid=".$sid;
        if ($result = @$connect-> query($sql))
        {
          while ($row = mysqli_fetch_row($result))
          {
            if ($row[0] != 0)
            {
              $allDailyAttendance++;
            }
          }
        }
      }
    }
    if ($allDailyAttendance != 0)
    {
      $dailyAttendancePercentage = round((($allDailyAttendance / $allDailyLessons) * 100))."%";
      return $dailyAttendancePercentage;
    }
    else
    {
      return "0%";
    }
  }
}

?>
