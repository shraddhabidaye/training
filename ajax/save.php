<?php

include('config.php');
$fname = $_POST['name1'];
$lname = $_POST['name2'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$password = md5($_POST['psw']);


$query1="INSERT INTO users(first_name,last_name,email,mobile_no,password) VALUES('$fname','$lname','$email','$contact','$password')";
    $res = $conn->query($query1);

    if($res==true)
    {
      echo "User data was inserted successfully";
    }
    else{
     echo  "Error: " . $query1 . "<br>" . mysqli_error($db);
    }
      
?>
