<?php
  include("config.php");

  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $contact=$_POST['contact'];
	$email=$_POST['email'];
	$password=$_POST['pass1'];
  $query1 = "INSERT INTO users (first_name,last_name,email,mobile_no,password)
   VALUES('".$fname."', '".$lname."', '".$email."', ".$contact.", '".$password."')";
$res = $conn->query($query1);
	if (mysqli_query($conn, $query1)) {
		echo json_encode(array("statusCode"=>200));
	}
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
 ?>
