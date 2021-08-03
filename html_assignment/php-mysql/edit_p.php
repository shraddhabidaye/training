<?php include_once("config.php");

  if (isset($_POST['up_user']))
   {

    // receive all input values from the form

      $firstname = $_POST['name1'];
      $lastname = $_POST['name2'];
      $contact = $_POST['num1'];
  }

      echo strlen($firstname);
    $email = $_SESSION["login_email"];
  if(strlen($firstname)!= 0)
  {

    $query = " UPDATE users SET first_name = '$firstname' WHERE email = ''$email'";
    $res = $conn->query($query);

  }
  if(strlen($lastname)!=0)
  {
  $query=" UPDATE users SET last_name = $lastname WHERE email=$email";
      $res = $conn->query($query);

  }
  if(strlen($contact)!=0)
  {
  $query=" UPDATE users SET mobile_no = $contact WHERE email=$email";
      $res = $conn->query($query);
  }
    header('location:account.php');

?>
