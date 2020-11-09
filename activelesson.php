<?php

function activelesson()
{
  require "connect.php";
  $connect = @new mysqli($host, $userDB, $passwordDB, $database);
  if ($connect->connect_errno!=0)
  {
    echo "Error: ".$connect->connect_errno;
  }
  else
  {
    $nowStamp = time();
    $lessonTimeAfter = $nowStamp + 2700;
    $sql = "SHOW TABLES FROM ".$database;
    $result = @$connect-> query($sql);
    $highestCheck = 0;
    while ($row = mysqli_fetch_row($result))
    {
      if (strspn($row[0],"lesson") == 6)
      {
        $tableCheck = $row[0];
        $tableCheck = substr($tableCheck,6);
        if ($tableCheck > $highestCheck)
        {
          if ($tableCheck < $lessonTimeAfter)
          {
            $highestCheck = $tableCheck;
          }
        }
      }
    }
  return $highestCheck;
  }
}

?>
