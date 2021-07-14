<?php
  $currentyear=idate("Y");                  //idate() is used to convert date to integer format.
  for($i=$currentyear;$i<=$currentyear+4;$i++)
    {
      $count=0;
      if($i%400==0 || $i%4==0)
        {
          echo"The next leap year is:",$i;
          $count++;
        }
      if($count>0)
        break;
    }
?>
