<?php
include('config.php');

$fname = $_POST['name1'];
$lname = $_POST['name2'];
$contact = $_POST['num1'];
$res=false;
$email = $_SESSION["login_email"];
if(strlen($fname)!= 0)
  {
    $query = " UPDATE users SET first_name = '$fname' WHERE email = '$email'";
    $res = $conn->query($query);
  }
if(strlen($lname)!=0)
  {
    $query=" UPDATE users SET last_name = '$lname' WHERE email = '$email'";
    $res = $conn->query($query);
  }
if(strlen($contact)!=0)
  {
    $query=" UPDATE users SET mobile_no = '$contact' WHERE email = '$email'";
    $res = $conn->query($query);
  }
  if($res==true)
  {
    echo "User data was inserted successfully";
  }
  // header('location:edit.php');
?>
