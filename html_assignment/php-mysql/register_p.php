<?php include_once("config.php");
if (isset($_POST['reg_user'])) {

  // receive all input values from the form
  $firstname = $_POST['name1'];
  $lastname = $_POST['name2'];
  $contact = $_POST['num1'];
  $email = $_POST['email'];
  $password_1 = $_POST['psw'];
  $password_2 = $_POST['psw-repeat'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "firstname is required"); }
  if (empty($lastname)) { array_push($errors, "lastname is required"); }
  if (empty($contact)) { array_push($errors, "contact no. is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
  array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  echo $user_check_query ;
  $result = $conn->query($user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['email'] === $email) {
      echo "exixts";
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
//  if (count($errors) == 0) {

    $query1 = "INSERT INTO users (first_name,last_name,email,mobile_no,password)
          VALUES('".$firstname."', '".$lastname."', '".$email."', ".$contact.", '".$password_1."')";
    echo $query1;
    $res = $conn->query($query1);
    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You are now logged in";

    header('location: index.php');
//  }
}
 ?>
