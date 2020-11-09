<?php

function semester($sid)
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
    $nowYear = date('Y');
    if ($nowMonth > 8 or $nowMonth < 3)
    {
      if ($nowMonth > 8 and $nowMonth <= 12)
      {
        $nextYear = $nowYear + 1;
        $semesterStart = strtotime("1.09.".$nowYear);
        if(date('L', strtotime("1.01".$nextYear)) == 0)
        {
          $semesterEnd = strtotime("28.02.".$nextYear) + 86399;
        }
        else
        {
          $semesterEnd = strtotime("29.02.".$nextYear) + 86399;
        }
      }
      if ($nowMonth > 0 and $nowMonth < 3)
      {
        $previousYear = $nowYear - 1;
        $semesterStart = strtotime("1.09.".$previousYear);
        if(date('L') == 0)
        {
          $semesterEnd = strtotime("28.02.".$nowYear) + 86399;
        }
        else
        {
          $semesterEnd = strtotime("29.02.".$nowYear) + 86399;
        }
      }
    }
    elseif ($nowMonth > 2 and $nowMonth < 9)
    {
      $semesterStart = strtotime("1.03.".$nowYear);
      $semesterEnd = strtotime("31.08.".$nowYear) + 86399;
    }

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
    $allSemesterLessons = 0;
    $allSemesterAttendance = 0;
    for ($i=0; $i < $numberOfLessons; $i++) {
      if (substr($lessons[$i],6) > $semesterStart and substr($lessons[$i],6) < $semesterEnd)
      {
        $allSemesterLessons++;
        $sql = "SELECT status FROM ".$lessons[$i]." WHERE sid=".$sid;
        if ($result = @$connect-> query($sql))
        {
          while ($row = mysqli_fetch_row($result))
          {
            if ($row[0] != 0)
            {
              $allSemesterAttendance++;
            }
          }
        }
      }
    }
    if ($allSemesterAttendance != 0)
    {
      $dailyAttendancePercentage = round((($allSemesterAttendance / $allSemesterLessons) * 100))."%";
      return $dailyAttendancePercentage;
    }
    else
    {
      return "0%";
    }
  }
}

?>
