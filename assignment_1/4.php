<?php
  echo"the key is:4"."<br>";
  $arr=array(1,4,8,6,9,7);
  echo"the array is:";
  print_r($arr);
  if(in_array(4,$arr))
    {
      echo"<br> Key found";
    }
  else
    {
      echo "<br> Key not found";
    }
?>
