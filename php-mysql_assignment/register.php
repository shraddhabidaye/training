<?php
  require_once("config.php");
?>
<html>
  <head>
    <title>register</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div>
      <form method="post" action="register_backend.php">
        <div class="container">
          <div class="container1">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="first_name"><b>First Name:</b></label>
            <input type="text" placeholder="first name" name="name1" required>

            <label for="last_name"><b>Last Name:</b></label>
            <input type="text" placeholder="last name" name="name2" required>

            <label for="mobile"><b>Contact No.:</b></label>
            <input type="number" placeholder="contact no." name="num1" required>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

            <div class="clearfix">
              <button type="submit" class="signupbtn" name="reg_user">Sign Up</button>
            </div>
          </div>  
        </div>
      </form>
    </div>
  </body>
</html>
