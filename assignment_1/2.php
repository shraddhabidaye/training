<?php
  $str1= "This,is,training";
  $search_char=",";
  $replace_char="*";
  echo "Original string is: $str1<br> ";
  $replaced_str=str_replace($search_char,$replace_char,$str1);
  echo "Replaced string is: $replaced_str";

?>
