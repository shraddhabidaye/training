<?php
  $currentyear=idate("Y");
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
