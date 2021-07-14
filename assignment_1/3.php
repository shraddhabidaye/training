<?php
  $str1="This is Cat";
  $str2="this is cat";
  $str3="hello world";
  echo "the string1:$str1 <br> ";
  echo"the string2 is:$str2 <br> ";
  echo"the string3 is:$str3 <br>";
  echo "comparing string1 & string2 <br>";
  $result=strncasecmp($str1,$str2,9);

  if ($result==0)
    {
      echo"string matched <br>";
    }
  else
   {
      echo " string is different <br>";
    }
  echo "comparing string1 & string2(case sensitive) <br>";
  $result=strncmp($str1,$str2,9);
  if ($result==0)
    {
      echo"string matched <br>";
    }
  else
    {
      echo " string is different <br>";
    }
    echo "comparing string1 & string3 <br>";
    $result=strcmp($str1,$str3,);
    if ($result==0)
      {
        echo"string matched <br>";
      }
    else
      {
        echo " string is different <br>";
      }
?>
