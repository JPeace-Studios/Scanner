<?php

function monthly($sid)
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
    $nowMonth = date('m');
    switch ($nowMonth) {
      case 1:
        $numberOfDays = 31;
        break;
      case 2:
        if(date('L') == 0)
        {
          $numberOfDays = 28;
        }
        else
        {
          $numberOfDays = 29;
        }
        break;
      case 3:
        $numberOfDays = 31;
        break;
      case 4:
        $numberOfDays = 30;
        break;
      case 5:
        $numberOfDays = 31;
        break;
      case 6:
        $numberOfDays = 30;
        break;
      case 7:
        $numberOfDays = 31;
        break;
      case 8:
        $numberOfDays = 31;
        break;
      case 9:
        $numberOfDays = 30;
        break;
      case 10:
        $numberOfDays = 31;
        break;
      case 11:
        $numberOfDays = 30;
        break;
      case 12:
        $numberOfDays = 31;
        break;
      default:
        echo "Error occured";
        break;
    }
    $daysToSubstract = date('d') * 86400;
    $hoursToSubtract = date('H') * 3600;
    $minutesToSubtract = date('i') * 60;
    $secoundsToSubtract = date('s');
    $allToSubtract = $daysToSubstract + $hoursToSubtract + $minutesToSubtract + $secoundsToSubtract;
    $monthStart = $nowStamp - $allToSubtract;
    $numberOfDays = ($numberOfDays * 86400) + 86399;
    $monthEnd = $monthStart + $numberOfDays;

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
    $allMonthlyLessons = 0;
    $allMonthlyAttendance = 0;
    for ($i=0; $i < $numberOfLessons; $i++) {
      if (substr($lessons[$i],6) > $monthStart and substr($lessons[$i],6) < $monthEnd)
      {
        $allMonthlyLessons++;
        $sql = "SELECT status FROM ".$lessons[$i]." WHERE sid=".$sid;
        if ($result = @$connect-> query($sql))
        {
          while ($row = mysqli_fetch_row($result))
          {
            if ($row[0] != 0)
            {
              $allMonthlyAttendance++;
            }
          }
        }
      }
    }
    if ($allMonthlyAttendance != 0)
    {
      $dailyAttendancePercentage = round((($allMonthlyAttendance / $allMonthlyLessons) * 100))."%";
      return $dailyAttendancePercentage;
    }
    else
    {
      return "0%";
    }
  }
}

?>
