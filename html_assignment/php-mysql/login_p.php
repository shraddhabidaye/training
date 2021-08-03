<?php
include_once("config.php");

  if(isset($_POST['login_btn'])){
  $login = $_POST['email'];
  $password = $_POST['psw'];
  $query = "SELECT * FROM users WHERE email='$login'";
  echo $query;
  $res = $conn->query($query);
  $numRows = mysqli_num_rows($res);
  if($numRows  == 1){
        $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['password']))
        {
           $_SESSION["login_sess"]="1";

           header("location:account.php");
        }
        else{
     header("location:login.php?loginerror=".$login);
        }
    }
    else{
   header("location:login.php?loginerror=".$login);
     }


?>
