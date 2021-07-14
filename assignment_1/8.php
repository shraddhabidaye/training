<?php
  //array mege function
  $arr1=array(1,6,8,9,"hi","hello");
  $arr2=array(5,9,4,0,2);
  print_r($arr1);
  print_r($arr2);
  echo "<br>";
  print_r(array_merge($arr1,$arr2));
  //implode
  echo "<br>" . implode(" ",$arr1);
  //explode
  $str="Hi this is human";
  echo "<br> ";
  print_r(explode(" ",$str));
  //string functions
  echo "<br> the length of sting is:" . strlen($str);
  echo"<br> word count:" . str_word_count($str);
  echo "<br> string reverse:" . strrev($str);
  echo "<br>";
  print_r(str_split($str));
?>
