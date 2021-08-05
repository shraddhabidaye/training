<?php
	include 'config.php';
	$fname=$_POST['fname'];
  $lname=$_POST['lname'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$password=$_POST['pass1'];
  echo $fname;
	$sql = "INSERT INTO users (first_name,last_name,email,mobile_no,password)
	VALUES ('$fname','$lname','$email','$contact','$password')";
  echo $sql;
$conn->query($sql);
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	}
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>
