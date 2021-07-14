<?php
  echo "the string1 is:This is Cat <br> the string2 is:this is cat<br>";
  echo "output of string compare without case sensitive:";
  echo strncasecmp("This is Cat","this is cat",9) . "<br>";
  echo "output of string compare with case sensitive:";
  echo strncmp("This is Cat","this is cat",9);
?>
