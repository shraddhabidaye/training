<?php

include_once("config.php");

  if(isset($_POST['login_btn']))
  {
    $login = $_POST['email'];
    $password_1 = $_POST['psw'];
    $password = md5($password_1);
    $query = "SELECT * FROM users WHERE email='$login'";
    echo $query;
    $res = $conn->query($query);

    $numRows = mysqli_num_rows($res);
    if($numRows  == 1)
    {


            $row = mysqli_fetch_assoc($res);
            if($password === $row['password'])
            {


               $_SESSION["login_sess"]="1";
                $_SESSION["login_email"]= $row['email'];
               header("location:account.php");
            }

            else
            {

                  header("location:index.php?loginerror=".$login);
            }

        }


        else
        {
          header("location:index.php?loginerror=".$login);
         }
  }

?>
