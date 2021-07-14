<?php
  $key=4;
  echo"the key is:$key"."<br>";
  $arr=array(1,4,8,6,9,7);
  echo"the array is:";
  print_r($arr);
  if(in_array($key,$arr))
    {
      echo"<br> Key found";
    }
  else
    {
      echo "<br> Key not found";
    }
?>
